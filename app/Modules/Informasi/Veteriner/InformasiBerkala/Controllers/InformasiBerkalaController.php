<?php

namespace App\Modules\Informasi\Veteriner\InformasiBerkala\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class InformasiBerkalaController extends AdminController
{
  protected $informasiberkalaFilter;
  protected $informasiberkalaModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\InformasiBerkala\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiBerkala\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->informasiberkalaFilter = model($this->modelPrefix . 'InformasiBerkalaFilter');
    $this->adminLink = (ADMIN_AREA . '/informasiberkala/');
    $this->categories = ['LAPORAN LHKPN', 'LAPORAN ASET', 'KESELAMATAN & KESEHATAN', 'LAPORAN DUMAS', 'REKAP PENGADUAN'];
  }

  public function list()
  {
    if (!auth()->user()->can('informasiberkala.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->informasiberkalaFilter->filter($this->request->getPost('filters'));

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
      'informasiberkala'         => $this->informasiberkalaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->informasiberkalaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new informasiberkala" form.
   */
  public function create()
  {
    if (!auth()->user()->can('informasiberkala.create')) {
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
   * Display the Edit form for a single informasiberkala.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasiberkalaModel = model($this->modelPrefix . 'InformasiBerkalaModel');

    $informasiberkala = $informasiberkalaModel->withDeleted()->find($pageId);
    if ($informasiberkala === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiBerkala.informasiberkala')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'informasiberkala'   => $informasiberkala,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a informasiberkala.
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

    if (!auth()->user()->can('informasiberkala.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasiberkalaModel = model($this->modelPrefix . 'InformasiBerkalaModel');

    $informasiberkala = $pageId !== null
      ? $informasiberkalaModel->find($pageId)
      : $informasiberkalaModel->newPage();

    /** 
     * if there is a informasiberkala id (so we run an update operation)
     * but such informasiberkala is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($informasiberkala === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiBerkala.informasiberkala')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $informasiberkala->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $informasiberkala->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($informasiberkalaModel->save($informasiberkala) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $informasiberkalaModel->errors());
    }

    if (!isset($informasiberkala->id) || !is_numeric(($informasiberkala->id))) {
      $informasiberkala->id = $informasiberkalaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $informasiberkala->id))->with('message', lang('Bonfire.resourceSaved', [lang('InformasiBerkala.informasiberkala')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('informasiberkala.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasiberkalaModel = model($this->modelPrefix . 'InformasiBerkalaModel');
    /** @var User|null $user */
    $informasiberkala = $informasiberkalaModel->find($pageId);

    if ($informasiberkala === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiBerkala.informasiberkala')]));
    }

    if (!$informasiberkalaModel->delete($informasiberkala->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('InformasiBerkala.informasiberkala')]));
  }


  /** 
   * Deletes multiple informasiberkala from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('informasiberkala.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('InformasiBerkala.informasiberkala')]));
    }
    $ids = array_keys($ids);

    $informasiberkalaModel = model($this->modelPrefix . 'InformasiBerkalaModel');

    if (!$informasiberkalaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('InformasiBerkala.informasiberkala')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $informasiberkalaModel = model($this->modelPrefix . 'InformasiBerkalaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($informasiberkalaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
