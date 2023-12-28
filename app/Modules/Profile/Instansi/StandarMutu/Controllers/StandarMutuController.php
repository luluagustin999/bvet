<?php

namespace App\Modules\Profile\Instansi\StandarMutu\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class StandarMutuController extends AdminController
{
  protected $standarmutuFilter;
  protected $standarmutuModel;
  protected $adminLink;
  protected $types;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\StandarMutu\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\StandarMutu\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->standarmutuFilter = model($this->modelPrefix . 'StandarMutuFilter');
    $this->adminLink = (ADMIN_AREA . '/standarmutu/');
    $this->types = ['IMAGE', 'VIDEO'];
  }

  public function list()
  {
    if (!auth()->user()->can('standarmutu.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->standarmutuFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'title'         => 'Title',
        'type'         => 'Type',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'standarmutu'         => $this->standarmutuFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->standarmutuFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new standarmutu" form.
   */
  public function create()
  {
    if (!auth()->user()->can('standarmutu.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    // TODO: transfer this to templates / views and make automatic
    // $viewMeta = service('viewMeta');
    // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));


    return $this->render($this->viewPrefix . 'form', [
      'adminLink' => $this->adminLink,
      'types' => $this->types
    ]);
  }

  /**
   * Display the Edit form for a single standarmutu.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarmutuModel = model($this->modelPrefix . 'StandarMutuModel');

    $standarmutu = $standarmutuModel->withDeleted()->find($pageId);
    if ($standarmutu === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarMutu.standarmutu')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'standarmutu'   => $standarmutu,
      'adminLink' => $this->adminLink,
      'types' => $this->types,
    ]);
  }

  /**
   * Creates new or saves an edited a standarmutu.
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

    if (!auth()->user()->can('standarmutu.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarmutuModel = model($this->modelPrefix . 'StandarMutuModel');

    $standarmutu = $pageId !== null
      ? $standarmutuModel->find($pageId)
      : $standarmutuModel->newPage();

    /** 
     * if there is a standarmutu id (so we run an update operation)
     * but such standarmutu is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($standarmutu === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarMutu.standarmutu')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $standarmutu->$key = $value;
    }

    if ($standarmutu->type == 'IMAGE') {
      $file = $this->request->getFile('file');

      if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $publicPath = 'uploads/';
        $file->move(FCPATH . $publicPath, $newName);
        $standarmutu->file = 'uploads/' . $newName;
      }
    }

    /** attempt validate and save */

    if ($standarmutuModel->save($standarmutu) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $standarmutuModel->errors());
    }

    if (!isset($standarmutu->id) || !is_numeric(($standarmutu->id))) {
      $standarmutu->id = $standarmutuModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $standarmutu->id))->with('message', lang('Bonfire.resourceSaved', [lang('StandarMutu.standarmutu')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('standarmutu.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarmutuModel = model($this->modelPrefix . 'StandarMutuModel');
    /** @var User|null $user */
    $standarmutu = $standarmutuModel->find($pageId);

    if ($standarmutu === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarMutu.standarmutu')]));
    }

    if (!$standarmutuModel->delete($standarmutu->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('StandarMutu.standarmutu')]));
  }


  /** 
   * Deletes multiple standarmutu from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('standarmutu.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('StandarMutu.standarmutu')]));
    }
    $ids = array_keys($ids);

    $standarmutuModel = model($this->modelPrefix . 'StandarMutuModel');

    if (!$standarmutuModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('StandarMutu.standarmutu')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $standarmutuModel = model($this->modelPrefix . 'StandarMutuModel');
    $validation = \Config\Services::validation();
    $validation->setRules($standarmutuModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }

  public function types()
  {
    if ($this->request->getGet('type') === "IMAGE") {
      return $this->render($this->viewPrefix . '_type_image', [
        'adminLink' => $this->adminLink,
      ]);
    } else {
      return $this->render($this->viewPrefix . '_type_video', [
        'adminLink' => $this->adminLink,
      ]);
    }
  }
}
