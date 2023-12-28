<?php

namespace App\Modules\Informasi\Veteriner\InformasiSetiap\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class InformasiSetiapController extends AdminController
{
  protected $informasisetiapFilter;
  protected $informasisetiapModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\InformasiSetiap\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiSetiap\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->informasisetiapFilter = model($this->modelPrefix . 'InformasiSetiapFilter');
    $this->adminLink = (ADMIN_AREA . '/informasisetiap/');
    $this->categories = ['LAPORAN PERJANJIAN KERJASAMA', 'LAPORAN SURAT MENYURAT', 'HASIL PENELITIAN', 'INFORMASI REGULASI', 'PERSYARATAN PERIZINAN', 'DAFTAR INFORMASI PUBLIK', 'DAFTAR INFORMASI DIKECUALIKAN', 'DAFTAR RENCANA KEBIJAKAN'];
  }

  public function list()
  {
    if (!auth()->user()->can('informasisetiap.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->informasisetiapFilter->filter($this->request->getPost('filters'));

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
      'informasisetiap'         => $this->informasisetiapFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->informasisetiapFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new informasisetiap" form.
   */
  public function create()
  {
    if (!auth()->user()->can('informasisetiap.create')) {
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
   * Display the Edit form for a single informasisetiap.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisetiapModel = model($this->modelPrefix . 'InformasiSetiapModel');

    $informasisetiap = $informasisetiapModel->withDeleted()->find($pageId);
    if ($informasisetiap === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSetiap.informasisetiap')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'informasisetiap'   => $informasisetiap,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a informasisetiap.
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

    if (!auth()->user()->can('informasisetiap.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisetiapModel = model($this->modelPrefix . 'InformasiSetiapModel');

    $informasisetiap = $pageId !== null
      ? $informasisetiapModel->find($pageId)
      : $informasisetiapModel->newPage();

    /** 
     * if there is a informasisetiap id (so we run an update operation)
     * but such informasisetiap is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($informasisetiap === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSetiap.informasisetiap')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $informasisetiap->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $informasisetiap->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($informasisetiapModel->save($informasisetiap) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $informasisetiapModel->errors());
    }

    if (!isset($informasisetiap->id) || !is_numeric(($informasisetiap->id))) {
      $informasisetiap->id = $informasisetiapModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $informasisetiap->id))->with('message', lang('Bonfire.resourceSaved', [lang('InformasiSetiap.informasisetiap')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('informasisetiap.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisetiapModel = model($this->modelPrefix . 'InformasiSetiapModel');
    /** @var User|null $user */
    $informasisetiap = $informasisetiapModel->find($pageId);

    if ($informasisetiap === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSetiap.informasisetiap')]));
    }

    if (!$informasisetiapModel->delete($informasisetiap->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('InformasiSetiap.informasisetiap')]));
  }


  /** 
   * Deletes multiple informasisetiap from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('informasisetiap.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('InformasiSetiap.informasisetiap')]));
    }
    $ids = array_keys($ids);

    $informasisetiapModel = model($this->modelPrefix . 'InformasiSetiapModel');

    if (!$informasisetiapModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('InformasiSetiap.informasisetiap')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $informasisetiapModel = model($this->modelPrefix . 'InformasiSetiapModel');
    $validation = \Config\Services::validation();
    $validation->setRules($informasisetiapModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
