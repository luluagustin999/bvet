<?php

namespace App\Modules\Informasi\Veteriner\InformasiSerta\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class InformasiSertaController extends AdminController
{
  protected $informasisertaFilter;
  protected $informasisertaModel;
  protected $adminLink;
  protected $categories;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\InformasiSerta\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiSerta\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->informasisertaFilter = model($this->modelPrefix . 'InformasiSertaFilter');
    $this->adminLink = (ADMIN_AREA . '/informasiserta/');
    $this->categories = ['PENCEGAHAN COVID19', 'PENYAKIT MULUT DAN KUKU', 'PENYAKIT ZOONOSIS LAINNYA'];
  }

  public function list()
  {
    if (!auth()->user()->can('informasiserta.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->informasisertaFilter->filter($this->request->getPost('filters'));

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
      'informasiserta'         => $this->informasisertaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->informasisertaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new informasiserta" form.
   */
  public function create()
  {
    if (!auth()->user()->can('informasiserta.create')) {
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
   * Display the Edit form for a single informasiserta.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisertaModel = model($this->modelPrefix . 'InformasiSertaModel');

    $informasiserta = $informasisertaModel->withDeleted()->find($pageId);
    if ($informasiserta === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSerta.informasiserta')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'informasiserta'   => $informasiserta,
      'adminLink' => $this->adminLink,
      'categories' => $this->categories,
    ]);
  }

  /**
   * Creates new or saves an edited a informasiserta.
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

    if (!auth()->user()->can('informasiserta.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisertaModel = model($this->modelPrefix . 'InformasiSertaModel');

    $informasiserta = $pageId !== null
      ? $informasisertaModel->find($pageId)
      : $informasisertaModel->newPage();

    /** 
     * if there is a informasiserta id (so we run an update operation)
     * but such informasiserta is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($informasiserta === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSerta.informasiserta')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $informasiserta->$key = $value;
    }

    $file = $this->request->getFile('file');

    if ($file->isValid() && !$file->hasMoved()) {
      $newName = $file->getRandomName();
      $publicPath = 'uploads/';
      $file->move(FCPATH . $publicPath, $newName);
      $informasiserta->file = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($informasisertaModel->save($informasiserta) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $informasisertaModel->errors());
    }

    if (!isset($informasiserta->id) || !is_numeric(($informasiserta->id))) {
      $informasiserta->id = $informasisertaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $informasiserta->id))->with('message', lang('Bonfire.resourceSaved', [lang('InformasiSerta.informasiserta')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('informasiserta.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $informasisertaModel = model($this->modelPrefix . 'InformasiSertaModel');
    /** @var User|null $user */
    $informasiserta = $informasisertaModel->find($pageId);

    if ($informasiserta === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('InformasiSerta.informasiserta')]));
    }

    if (!$informasisertaModel->delete($informasiserta->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('InformasiSerta.informasiserta')]));
  }


  /** 
   * Deletes multiple informasiserta from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('informasiserta.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('InformasiSerta.informasiserta')]));
    }
    $ids = array_keys($ids);

    $informasisertaModel = model($this->modelPrefix . 'InformasiSertaModel');

    if (!$informasisertaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('InformasiSerta.informasiserta')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $informasisertaModel = model($this->modelPrefix . 'InformasiSertaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($informasisertaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
