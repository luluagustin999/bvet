<?php

namespace App\Modules\Informasi\Umum\Sop\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class SopController extends AdminController
{
  protected $sopFilter;
  protected $sopModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Sop\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Sop\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->sopFilter = model($this->modelPrefix . 'SopFilter');
    $this->adminLink = (ADMIN_AREA . '/sop/');
  }

  public function list()
  {
    if (!auth()->user()->can('sop.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->sopFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'deskripsi'         => 'Deskripsi',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'sop'         => $this->sopFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->sopFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new sop" form.
   */
  public function create()
  {
    if (!auth()->user()->can('sop.create')) {
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
   * Display the Edit form for a single sop.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $sopModel = model($this->modelPrefix . 'SopModel');

    $sop = $sopModel->withDeleted()->find($pageId);
    if ($sop === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Sop.sop')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'sop'   => $sop,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a sop.
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

    if (!auth()->user()->can('sop.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $sopModel = model($this->modelPrefix . 'SopModel');

    $sop = $pageId !== null
      ? $sopModel->find($pageId)
      : $sopModel->newPage();

    /** 
     * if there is a sop id (so we run an update operation)
     * but such sop is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($sop === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Sop.sop')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $sop->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $sop->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($sopModel->save($sop) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $sopModel->errors());
    }

    if (!isset($sop->id) || !is_numeric(($sop->id))) {
      $sop->id = $sopModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $sop->id))->with('message', lang('Bonfire.resourceSaved', [lang('Sop.sop')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('sop.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $sopModel = model($this->modelPrefix . 'SopModel');
    /** @var User|null $user */
    $sop = $sopModel->find($pageId);

    if ($sop === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Sop.sop')]));
    }

    if (!$sopModel->delete($sop->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Sop.sop')]));
  }


  /** 
   * Deletes multiple sop from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('sop.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Sop.sop')]));
    }
    $ids = array_keys($ids);

    $sopModel = model($this->modelPrefix . 'SopModel');

    if (!$sopModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Sop.sop')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $sopModel = model($this->modelPrefix . 'SopModel');
    $validation = \Config\Services::validation();
    $validation->setRules($sopModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
