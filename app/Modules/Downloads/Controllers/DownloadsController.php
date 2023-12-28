<?php

namespace App\Modules\Downloads\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class DownloadsController extends AdminController
{
  protected $downloadsFilter;
  protected $downloadsModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Downloads\Views\\';
  protected $modelPrefix = 'App\Modules\Downloads\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->downloadsFilter = model($this->modelPrefix . 'DownloadsFilter');
    $this->adminLink = (ADMIN_AREA . '/downloads/');
    $this->categories = ['DIPA', 'ANGGARAN', 'RENCANA'];
  }

  public function list()
  {
    if (!auth()->user()->can('downloads.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->downloadsFilter->filter($this->request->getPost('filters'));

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
      'downloads'         => $this->downloadsFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->downloadsFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new download" form.
   */
  public function create()
  {
    if (!auth()->user()->can('downloads.create')) {
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
   * Display the Edit form for a single download.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $downloadsModel = model($this->modelPrefix . 'DownloadsModel');

    $download = $downloadsModel->withDeleted()->find($pageId);
    if ($download === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Downloads.download')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'download'   => $download,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a download.
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

    if (!auth()->user()->can('downloads.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $downloadsModel = model($this->modelPrefix . 'DownloadsModel');

    $download = $pageId !== null
      ? $downloadsModel->find($pageId)
      : $downloadsModel->newPage();

    /** 
     * if there is a download id (so we run an update operation)
     * but such download is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($download === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Downloads.download')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $download->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $download->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($downloadsModel->save($download) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $downloadsModel->errors());
    }

    if (!isset($download->id) || !is_numeric(($download->id))) {
      $download->id = $downloadsModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $download->id))->with('message', lang('Bonfire.resourceSaved', [lang('Downloads.download')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('downloads.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $downloadsModel = model($this->modelPrefix . 'DownloadsModel');
    /** @var User|null $user */
    $download = $downloadsModel->find($pageId);

    if ($download === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Downloads.download')]));
    }

    if (!$downloadsModel->delete($download->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Downloads.download')]));
  }


  /** 
   * Deletes multiple downloads from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('downloads.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Downloads.downloads')]));
    }
    $ids = array_keys($ids);

    $downloadsModel = model($this->modelPrefix . 'DownloadsModel');

    if (!$downloadsModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Downloads.downloads')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $downloadsModel = model($this->modelPrefix . 'DownloadsModel');
    $validation = \Config\Services::validation();
    $validation->setRules($downloadsModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
