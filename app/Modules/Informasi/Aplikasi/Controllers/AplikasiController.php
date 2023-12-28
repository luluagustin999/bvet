<?php

namespace App\Modules\Informasi\Aplikasi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class AplikasiController extends AdminController
{
  protected $aplikasiFilter;
  protected $aplikasiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Aplikasi\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Aplikasi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->aplikasiFilter = model($this->modelPrefix . 'AplikasiFilter');
    $this->adminLink = (ADMIN_AREA . '/aplikasi/');
  }

  public function list()
  {
    if (!auth()->user()->can('aplikasi.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->aplikasiFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'layanan'         => 'Layanan',
        'link'         => 'Link Website',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'aplikasi'         => $this->aplikasiFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->aplikasiFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new aplikasi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('aplikasi.create')) {
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
   * Display the Edit form for a single aplikasi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $aplikasiModel = model($this->modelPrefix . 'AplikasiModel');

    $aplikasi = $aplikasiModel->withDeleted()->find($pageId);
    if ($aplikasi === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Aplikasi.aplikasi')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'aplikasi'   => $aplikasi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a aplikasi.
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

    if (!auth()->user()->can('aplikasi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $aplikasiModel = model($this->modelPrefix . 'AplikasiModel');

    $aplikasi = $pageId !== null
      ? $aplikasiModel->find($pageId)
      : $aplikasiModel->newPage();

    /** 
     * if there is a aplikasi id (so we run an update operation)
     * but such aplikasi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($aplikasi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Aplikasi.aplikasi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $aplikasi->$key = $value;
    }

    /** attempt validate and save */

    if ($aplikasiModel->save($aplikasi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $aplikasiModel->errors());
    }

    if (!isset($aplikasi->id) || !is_numeric(($aplikasi->id))) {
      $aplikasi->id = $aplikasiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $aplikasi->id))->with('message', lang('Bonfire.resourceSaved', [lang('Aplikasi.aplikasi')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('aplikasi.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $aplikasiModel = model($this->modelPrefix . 'AplikasiModel');
    /** @var User|null $user */
    $aplikasi = $aplikasiModel->find($pageId);

    if ($aplikasi === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Aplikasi.aplikasi')]));
    }

    if (!$aplikasiModel->delete($aplikasi->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Aplikasi.aplikasi')]));
  }


  /** 
   * Deletes multiple aplikasi from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('aplikasi.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Aplikasi.aplikasi')]));
    }
    $ids = array_keys($ids);

    $aplikasiModel = model($this->modelPrefix . 'AplikasiModel');

    if (!$aplikasiModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Aplikasi.aplikasi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $aplikasiModel = model($this->modelPrefix . 'AplikasiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($aplikasiModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
