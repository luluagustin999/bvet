<?php

namespace App\Modules\Informasi\Veteriner\LaporanIkm\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class LaporanIkmController extends AdminController
{
  protected $laporanikmFilter;
  protected $laporanikmModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\LaporanIkm\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\LaporanIkm\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->laporanikmFilter = model($this->modelPrefix . 'LaporanIkmFilter');
    $this->adminLink = (ADMIN_AREA . '/laporanikm/');
  }

  public function list()
  {
    if (!auth()->user()->can('laporanikm.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->laporanikmFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'deskripsi'         => 'Deskripsi',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'laporanikm'         => $this->laporanikmFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->laporanikmFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new laporanikm" form.
   */
  public function create()
  {
    if (!auth()->user()->can('laporanikm.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    // TODO: transfer this to templates / views and make automatic
    // $viewMeta = service('viewMeta');
    // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));


    return $this->render($this->viewPrefix . 'form', [
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Display the Edit form for a single laporanikm.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $laporanikmModel = model($this->modelPrefix . 'LaporanIkmModel');

    $laporanikm = $laporanikmModel->withDeleted()->find($pageId);
    if ($laporanikm === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('LaporanIkm.laporanikm')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'laporanikm'   => $laporanikm,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a laporanikm.
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

    if (!auth()->user()->can('laporanikm.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $laporanikmModel = model($this->modelPrefix . 'LaporanIkmModel');

    $laporanikm = $pageId !== null
      ? $laporanikmModel->find($pageId)
      : $laporanikmModel->newPage();

    /** 
     * if there is a laporanikm id (so we run an update operation)
     * but such laporanikm is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($laporanikm === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('LaporanIkm.laporanikm')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $laporanikm->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $laporanikm->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($laporanikmModel->save($laporanikm) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $laporanikmModel->errors());
    }

    if (!isset($laporanikm->id) || !is_numeric(($laporanikm->id))) {
      $laporanikm->id = $laporanikmModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $laporanikm->id))->with('message', lang('Bonfire.resourceSaved', [lang('LaporanIkm.laporanikm')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('laporanikm.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $laporanikmModel = model($this->modelPrefix . 'LaporanIkmModel');
    /** @var User|null $user */
    $laporanikm = $laporanikmModel->find($pageId);

    if ($laporanikm === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('LaporanIkm.laporanikm')]));
    }

    if (!$laporanikmModel->delete($laporanikm->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('LaporanIkm.laporanikm')]));
  }


  /** 
   * Deletes multiple laporanikm from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('laporanikm.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('LaporanIkm.laporanikm')]));
    }
    $ids = array_keys($ids);

    $laporanikmModel = model($this->modelPrefix . 'LaporanIkmModel');

    if (!$laporanikmModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('LaporanIkm.laporanikm')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $laporanikmModel = model($this->modelPrefix . 'LaporanIkmModel');
    $validation = \Config\Services::validation();
    $validation->setRules($laporanikmModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
