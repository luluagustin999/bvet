<?php

namespace App\Modules\Program\RencanaKerja\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class RencanaKerjaController extends AdminController
{
  protected $rencanakerjaFilter;
  protected $rencanakerjaModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Program\RencanaKerja\Views\\';
  protected $modelPrefix = 'App\Modules\Program\RencanaKerja\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->rencanakerjaFilter = model($this->modelPrefix . 'RencanaKerjaFilter');
    $this->adminLink = (ADMIN_AREA . '/rencanakerja/');
    $this->categories = ['RENCANA STRATEGIS', 'RENCANA KERJA', 'RKT/RBA'];
  }

  public function list()
  {
    if (!auth()->user()->can('rencanakerja.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->rencanakerjaFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'deskripsi'         => 'Deskripsi',
        'category'         => 'Category',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'rencanakerja'         => $this->rencanakerjaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->rencanakerjaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new rencanakerja" form.
   */
  public function create()
  {
    if (!auth()->user()->can('rencanakerja.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    // TODO: transfer this to templates / views and make automatic
    // $viewMeta = service('viewMeta');
    // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));


    return $this->render($this->viewPrefix . 'form', [
      'adminLink' => $this->adminLink,
      'categories' => $this->categories
    ]);
  }

  /**
   * Display the Edit form for a single rencanakerja.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $rencanakerjaModel = model($this->modelPrefix . 'RencanaKerjaModel');

    $rencanakerja = $rencanakerjaModel->withDeleted()->find($pageId);
    if ($rencanakerja === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('RencanaKerja.rencanakerja')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'rencanakerja'   => $rencanakerja,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a rencanakerja.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pageId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink . ($pageId ?: 'new');

    if (!auth()->user()->can('rencanakerja.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $rencanakerjaModel = model($this->modelPrefix . 'RencanaKerjaModel');

    $rencanakerja = $pageId !== null
      ? $rencanakerjaModel->find($pageId)
      : $rencanakerjaModel->newPage();

    /** 
     * if there is a rencanakerja id (so we run an update operation)
     * but such rencanakerja is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($rencanakerja === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('RencanaKerja.rencanakerja')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $rencanakerja->$key = $value;
    }


    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $rencanakerja->file = 'uploads/' . $newName;
    }
    /** attempt validate and save */

    if ($rencanakerjaModel->save($rencanakerja) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $rencanakerjaModel->errors());
    }

    if (!isset($rencanakerja->id) || !is_numeric(($rencanakerja->id))) {
      $rencanakerja->id = $rencanakerjaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $rencanakerja->id))->with('message', lang('Bonfire.resourceSaved', [lang('RencanaKerja.rencanakerja')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('rencanakerja.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $rencanakerjaModel = model($this->modelPrefix . 'RencanaKerjaModel');
    /** @var User|null $user */
    $rencanakerja = $rencanakerjaModel->find($pageId);

    if ($rencanakerja === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('RencanaKerja.rencanakerja')]));
    }

    if (!$rencanakerjaModel->delete($rencanakerja->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('RencanaKerja.rencanakerja')]));
  }


  /** 
   * Deletes multiple rencanakerja from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('rencanakerja.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('RencanaKerja.rencanakerja')]));
    }
    $ids = array_keys($ids);

    $rencanakerjaModel = model($this->modelPrefix . 'RencanaKerjaModel');

    if (!$rencanakerjaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('RencanaKerja.rencanakerja')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $rencanakerjaModel = model($this->modelPrefix . 'RencanaKerjaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($rencanakerjaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
