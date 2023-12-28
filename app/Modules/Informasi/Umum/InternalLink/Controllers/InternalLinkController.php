<?php

namespace App\Modules\Informasi\Umum\InternalLink\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class InternalLinkController extends AdminController
{
  protected $internallinkFilter;
  protected $internallinkModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\InternalLink\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\InternalLink\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->internallinkFilter = model($this->modelPrefix . 'InternalLinkFilter');
    $this->adminLink = (ADMIN_AREA . '/internallink/');
  }

  public function list()
  {
    if (!auth()->user()->can('internallink.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->internallinkFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'instansi'         => 'Instansi',
        'alamat'         => 'Alamat',
        'link'         => 'Link Website',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'internallink'         => $this->internallinkFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->internallinkFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new internallink" form.
   */
  public function create()
  {
    if (!auth()->user()->can('internallink.create')) {
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
   * Display the Edit form for a single internallink.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $internallinkModel = model($this->modelPrefix . 'InternalLinkModel');

    $internallink = $internallinkModel->withDeleted()->find($pageId);
    if ($internallink === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InternalLink.internallink')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'internallink'   => $internallink,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a internallink.
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

    if (!auth()->user()->can('internallink.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $internallinkModel = model($this->modelPrefix . 'InternalLinkModel');

    $internallink = $pageId !== null
      ? $internallinkModel->find($pageId)
      : $internallinkModel->newPage();

    /** 
     * if there is a internallink id (so we run an update operation)
     * but such internallink is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($internallink === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('InternalLink.internallink')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $internallink->$key = $value;
    }

    /** attempt validate and save */

    if ($internallinkModel->save($internallink) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $internallinkModel->errors());
    }

    if (!isset($internallink->id) || !is_numeric(($internallink->id))) {
      $internallink->id = $internallinkModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $internallink->id))->with('message', lang('Bonfire.resourceSaved', [lang('InternalLink.internallink')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('internallink.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $internallinkModel = model($this->modelPrefix . 'InternalLinkModel');
    /** @var User|null $user */
    $internallink = $internallinkModel->find($pageId);

    if ($internallink === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InternalLink.internallink')]));
    }

    if (!$internallinkModel->delete($internallink->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('InternalLink.internallink')]));
  }


  /** 
   * Deletes multiple internallink from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('internallink.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('InternalLink.internallink')]));
    }
    $ids = array_keys($ids);

    $internallinkModel = model($this->modelPrefix . 'InternalLinkModel');

    if (!$internallinkModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('InternalLink.internallink')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $internallinkModel = model($this->modelPrefix . 'InternalLinkModel');
    $validation = \Config\Services::validation();
    $validation->setRules($internallinkModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
