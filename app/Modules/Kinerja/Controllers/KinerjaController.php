<?php

namespace App\Modules\Kinerja\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class KinerjaController extends AdminController
{
  protected $kinerjaFilter;
  protected $kinerjaModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Kinerja\Views\\';
  protected $modelPrefix = 'App\Modules\Kinerja\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->kinerjaFilter = model($this->modelPrefix . 'KinerjaFilter');
    $this->adminLink = (ADMIN_AREA . '/kinerja/');
    $this->categories = ['LAPORAN KEUANGAN', 'LAPORAN TAHUNAN', 'LAPORAN PPID', 'LAPORAN KINERJA', 'LAPORAN IKM', 'INFOGRAFIS KEUANGAN', 'CAPAIAN KINERJA'];
  }

  public function list()
  {
    if (!auth()->user()->can('kinerja.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->kinerjaFilter->filter($this->request->getPost('filters'));

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
      'kinerja'         => $this->kinerjaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->kinerjaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new kinerja" form.
   */
  public function create()
  {
    if (!auth()->user()->can('kinerja.create')) {
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
   * Display the Edit form for a single kinerja.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $kinerjaModel = model($this->modelPrefix . 'KinerjaModel');

    $kinerja = $kinerjaModel->withDeleted()->find($pageId);
    if ($kinerja === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Kinerja.kinerja')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'kinerja'   => $kinerja,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a kinerja.
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

    if (!auth()->user()->can('kinerja.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $kinerjaModel = model($this->modelPrefix . 'KinerjaModel');

    $kinerja = $pageId !== null
      ? $kinerjaModel->find($pageId)
      : $kinerjaModel->newPage();

    /** 
     * if there is a kinerja id (so we run an update operation)
     * but such kinerja is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($kinerja === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Kinerja.kinerja')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $kinerja->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $kinerja->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($kinerjaModel->save($kinerja) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $kinerjaModel->errors());
    }

    if (!isset($kinerja->id) || !is_numeric(($kinerja->id))) {
      $kinerja->id = $kinerjaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $kinerja->id))->with('message', lang('Bonfire.resourceSaved', [lang('Kinerja.kinerja')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('kinerja.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $kinerjaModel = model($this->modelPrefix . 'KinerjaModel');
    /** @var User|null $user */
    $kinerja = $kinerjaModel->find($pageId);

    if ($kinerja === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Kinerja.kinerja')]));
    }

    if (!$kinerjaModel->delete($kinerja->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Kinerja.kinerja')]));
  }


  /** 
   * Deletes multiple kinerja from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('kinerja.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Kinerja.kinerja')]));
    }
    $ids = array_keys($ids);

    $kinerjaModel = model($this->modelPrefix . 'KinerjaModel');

    if (!$kinerjaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Kinerja.kinerja')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $kinerjaModel = model($this->modelPrefix . 'KinerjaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($kinerjaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
