<?php

namespace App\Modules\Program\Anggaran\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class AnggaranController extends AdminController
{
  protected $anggaranFilter;
  protected $anggaranModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Program\Anggaran\Views\\';
  protected $modelPrefix = 'App\Modules\Program\Anggaran\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->anggaranFilter = model($this->modelPrefix . 'AnggaranFilter');
    $this->adminLink = (ADMIN_AREA . '/anggaran/');
    $this->categories = ['DIPA', 'RKAL/POK', 'REALISASI ANGGARAN', 'LAPORAN KEUANGAN'];
  }

  public function list()
  {
    if (!auth()->user()->can('anggaran.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->anggaranFilter->filter($this->request->getPost('filters'));

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
      'anggaran'         => $this->anggaranFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->anggaranFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new anggaran" form.
   */
  public function create()
  {
    if (!auth()->user()->can('anggaran.create')) {
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
   * Display the Edit form for a single anggaran.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $anggaranModel = model($this->modelPrefix . 'AnggaranModel');

    $anggaran = $anggaranModel->withDeleted()->find($pageId);
    if ($anggaran === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Anggaran.anggaran')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'anggaran'   => $anggaran,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a anggaran.
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

    if (!auth()->user()->can('anggaran.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $anggaranModel = model($this->modelPrefix . 'AnggaranModel');

    $anggaran = $pageId !== null
      ? $anggaranModel->find($pageId)
      : $anggaranModel->newPage();

    /** 
     * if there is a anggaran id (so we run an update operation)
     * but such anggaran is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($anggaran === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Anggaran.anggaran')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $anggaran->$key = $value;
    }

    $file = $this->request->getFile('file');


    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $anggaran->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($anggaranModel->save($anggaran) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $anggaranModel->errors());
    }

    if (!isset($anggaran->id) || !is_numeric(($anggaran->id))) {
      $anggaran->id = $anggaranModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $anggaran->id))->with('message', lang('Bonfire.resourceSaved', [lang('Anggaran.anggaran')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('anggaran.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $anggaranModel = model($this->modelPrefix . 'AnggaranModel');
    /** @var User|null $user */
    $anggaran = $anggaranModel->find($pageId);

    if ($anggaran === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Anggaran.anggaran')]));
    }

    if (!$anggaranModel->delete($anggaran->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Anggaran.anggaran')]));
  }


  /** 
   * Deletes multiple anggaran from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('anggaran.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Anggaran.anggaran')]));
    }
    $ids = array_keys($ids);

    $anggaranModel = model($this->modelPrefix . 'AnggaranModel');

    if (!$anggaranModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Anggaran.anggaran')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $anggaranModel = model($this->modelPrefix . 'AnggaranModel');
    $validation = \Config\Services::validation();
    $validation->setRules($anggaranModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
