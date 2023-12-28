<?php

namespace App\Modules\Informasi\Umum\ExternalLink\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class ExternalLinkController extends AdminController
{
  protected $externallinkFilter;
  protected $externallinkModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\ExternalLink\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\ExternalLink\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->externallinkFilter = model($this->modelPrefix . 'ExternalLinkFilter');
    $this->adminLink = (ADMIN_AREA . '/externallink/');
  }

  public function list()
  {
    if (!auth()->user()->can('externallink.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->externallinkFilter->filter($this->request->getPost('filters'));

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
      'externallink'         => $this->externallinkFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->externallinkFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new externallink" form.
   */
  public function create()
  {
    if (!auth()->user()->can('externallink.create')) {
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
   * Display the Edit form for a single externallink.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $externallinkModel = model($this->modelPrefix . 'ExternalLinkModel');

    $externallink = $externallinkModel->withDeleted()->find($pageId);
    if ($externallink === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('ExternalLink.externallink')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'externallink'   => $externallink,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a externallink.
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

    if (!auth()->user()->can('externallink.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $externallinkModel = model($this->modelPrefix . 'ExternalLinkModel');

    $externallink = $pageId !== null
      ? $externallinkModel->find($pageId)
      : $externallinkModel->newPage();

    /** 
     * if there is a externallink id (so we run an update operation)
     * but such externallink is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($externallink === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('ExternalLink.externallink')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $externallink->$key = $value;
    }

    /** attempt validate and save */

    if ($externallinkModel->save($externallink) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $externallinkModel->errors());
    }

    if (!isset($externallink->id) || !is_numeric(($externallink->id))) {
      $externallink->id = $externallinkModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $externallink->id))->with('message', lang('Bonfire.resourceSaved', [lang('ExternalLink.externallink')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('externallink.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $externallinkModel = model($this->modelPrefix . 'ExternalLinkModel');
    /** @var User|null $user */
    $externallink = $externallinkModel->find($pageId);

    if ($externallink === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('ExternalLink.externallink')]));
    }

    if (!$externallinkModel->delete($externallink->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('ExternalLink.externallink')]));
  }


  /** 
   * Deletes multiple externallink from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('externallink.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('ExternalLink.externallink')]));
    }
    $ids = array_keys($ids);

    $externallinkModel = model($this->modelPrefix . 'ExternalLinkModel');

    if (!$externallinkModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('ExternalLink.externallink')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $externallinkModel = model($this->modelPrefix . 'ExternalLinkModel');
    $validation = \Config\Services::validation();
    $validation->setRules($externallinkModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
