<?php

namespace App\Modules\Informasi\LayananPpid\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class LayananPpidController extends AdminController
{
  protected $layananppidFilter;
  protected $layananppidModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\LayananPpid\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\LayananPpid\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->layananppidFilter = model($this->modelPrefix . 'LayananPpidFilter');
    $this->adminLink = (ADMIN_AREA . '/layananppid/');
  }

  public function list()
  {
    if (!auth()->user()->can('layananppid.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->layananppidFilter->filter($this->request->getPost('filters'));

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
      'layananppid'         => $this->layananppidFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->layananppidFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new layananppid" form.
   */
  public function create()
  {
    if (!auth()->user()->can('layananppid.create')) {
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
   * Display the Edit form for a single layananppid.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $layananppidModel = model($this->modelPrefix . 'LayananPpidModel');

    $layananppid = $layananppidModel->withDeleted()->find($pageId);
    if ($layananppid === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('LayananPpid.layananppid')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'layananppid'   => $layananppid,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a layananppid.
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

    if (!auth()->user()->can('layananppid.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $layananppidModel = model($this->modelPrefix . 'LayananPpidModel');

    $layananppid = $pageId !== null
      ? $layananppidModel->find($pageId)
      : $layananppidModel->newPage();

    /** 
     * if there is a layananppid id (so we run an update operation)
     * but such layananppid is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($layananppid === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('LayananPpid.layananppid')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $layananppid->$key = $value;
    }

    /** attempt validate and save */

    if ($layananppidModel->save($layananppid) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $layananppidModel->errors());
    }

    if (!isset($layananppid->id) || !is_numeric(($layananppid->id))) {
      $layananppid->id = $layananppidModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $layananppid->id))->with('message', lang('Bonfire.resourceSaved', [lang('LayananPpid.layananppid')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('layananppid.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $layananppidModel = model($this->modelPrefix . 'LayananPpidModel');
    /** @var User|null $user */
    $layananppid = $layananppidModel->find($pageId);

    if ($layananppid === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('LayananPpid.layananppid')]));
    }

    if (!$layananppidModel->delete($layananppid->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('LayananPpid.layananppid')]));
  }


  /** 
   * Deletes multiple layananppid from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('layananppid.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('LayananPpid.layananppid')]));
    }
    $ids = array_keys($ids);

    $layananppidModel = model($this->modelPrefix . 'LayananPpidModel');

    if (!$layananppidModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('LayananPpid.layananppid')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $layananppidModel = model($this->modelPrefix . 'LayananPpidModel');
    $validation = \Config\Services::validation();
    $validation->setRules($layananppidModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
