<?php

namespace App\Modules\Informasi\Umum\Publikasi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PublikasiController extends AdminController
{
  protected $publikasiFilter;
  protected $publikasiModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Publikasi\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Publikasi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->publikasiFilter = model($this->modelPrefix . 'PublikasiFilter');
    $this->adminLink = (ADMIN_AREA . '/publikasi/');
    $this->categories = ['ARTIKEL', 'JURNAL', 'BULETIN', 'BUKU', 'BUKU', 'LEAFLET', 'POSTER'];
  }

  public function list()
  {
    if (!auth()->user()->can('publikasi.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->publikasiFilter->filter($this->request->getPost('filters'));

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
      'publikasi'         => $this->publikasiFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->publikasiFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new publikasi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('publikasi.create')) {
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
   * Display the Edit form for a single publikasi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $publikasiModel = model($this->modelPrefix . 'PublikasiModel');

    $publikasi = $publikasiModel->withDeleted()->find($pageId);
    if ($publikasi === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Publikasi.publikasi')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'publikasi'   => $publikasi,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a publikasi.
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

    if (!auth()->user()->can('publikasi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $publikasiModel = model($this->modelPrefix . 'PublikasiModel');

    $publikasi = $pageId !== null
      ? $publikasiModel->find($pageId)
      : $publikasiModel->newPage();

    /** 
     * if there is a publikasi id (so we run an update operation)
     * but such publikasi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($publikasi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Publikasi.publikasi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $publikasi->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $publikasi->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($publikasiModel->save($publikasi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $publikasiModel->errors());
    }

    if (!isset($publikasi->id) || !is_numeric(($publikasi->id))) {
      $publikasi->id = $publikasiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $publikasi->id))->with('message', lang('Bonfire.resourceSaved', [lang('Publikasi.publikasi')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('publikasi.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $publikasiModel = model($this->modelPrefix . 'PublikasiModel');
    /** @var User|null $user */
    $publikasi = $publikasiModel->find($pageId);

    if ($publikasi === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Publikasi.publikasi')]));
    }

    if (!$publikasiModel->delete($publikasi->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Publikasi.publikasi')]));
  }


  /** 
   * Deletes multiple publikasi from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('publikasi.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Publikasi.publikasi')]));
    }
    $ids = array_keys($ids);

    $publikasiModel = model($this->modelPrefix . 'PublikasiModel');

    if (!$publikasiModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Publikasi.publikasi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $publikasiModel = model($this->modelPrefix . 'PublikasiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($publikasiModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
