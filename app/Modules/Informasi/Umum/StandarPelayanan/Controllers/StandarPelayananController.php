<?php

namespace App\Modules\Informasi\Umum\StandarPelayanan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class StandarPelayananController extends AdminController
{
  protected $standarpelayananFilter;
  protected $standarpelayananModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\StandarPelayanan\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\StandarPelayanan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->standarpelayananFilter = model($this->modelPrefix . 'StandarPelayananFilter');
    $this->adminLink = (ADMIN_AREA . '/standarpelayanan/');
  }

  public function list()
  {
    if (!auth()->user()->can('standarpelayanan.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->standarpelayananFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'deskripsi'         => 'Deskripsi',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'standarpelayanan'         => $this->standarpelayananFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->standarpelayananFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new standarpelayanan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('standarpelayanan.create')) {
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
   * Display the Edit form for a single standarpelayanan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarpelayananModel = model($this->modelPrefix . 'StandarPelayananModel');

    $standarpelayanan = $standarpelayananModel->withDeleted()->find($pageId);
    if ($standarpelayanan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarPelayanan.standarpelayanan')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'standarpelayanan'   => $standarpelayanan,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a standarpelayanan.
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

    if (!auth()->user()->can('standarpelayanan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarpelayananModel = model($this->modelPrefix . 'StandarPelayananModel');

    $standarpelayanan = $pageId !== null
      ? $standarpelayananModel->find($pageId)
      : $standarpelayananModel->newPage();

    /** 
     * if there is a standarpelayanan id (so we run an update operation)
     * but such standarpelayanan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($standarpelayanan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarPelayanan.standarpelayanan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $standarpelayanan->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $standarpelayanan->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($standarpelayananModel->save($standarpelayanan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $standarpelayananModel->errors());
    }

    if (!isset($standarpelayanan->id) || !is_numeric(($standarpelayanan->id))) {
      $standarpelayanan->id = $standarpelayananModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $standarpelayanan->id))->with('message', lang('Bonfire.resourceSaved', [lang('StandarPelayanan.standarpelayanan')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('standarpelayanan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $standarpelayananModel = model($this->modelPrefix . 'StandarPelayananModel');
    /** @var User|null $user */
    $standarpelayanan = $standarpelayananModel->find($pageId);

    if ($standarpelayanan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('StandarPelayanan.standarpelayanan')]));
    }

    if (!$standarpelayananModel->delete($standarpelayanan->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('StandarPelayanan.standarpelayanan')]));
  }


  /** 
   * Deletes multiple standarpelayanan from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('standarpelayanan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('StandarPelayanan.standarpelayanan')]));
    }
    $ids = array_keys($ids);

    $standarpelayananModel = model($this->modelPrefix . 'StandarPelayananModel');

    if (!$standarpelayananModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('StandarPelayanan.standarpelayanan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $standarpelayananModel = model($this->modelPrefix . 'StandarPelayananModel');
    $validation = \Config\Services::validation();
    $validation->setRules($standarpelayananModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
