<?php

namespace App\Modules\Galleries\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class GalleriesController extends AdminController
{
  protected $galleriesFilter;
  protected $galleriesModel;
  protected $adminLink;
  protected $types;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Galleries\Views\\';
  protected $modelPrefix = 'App\Modules\Galleries\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->galleriesFilter = model($this->modelPrefix . 'GalleriesFilter');
    $this->adminLink = (ADMIN_AREA . '/galleries/');
    $this->types = ['IMAGE', 'VIDEO'];
  }

  public function list()
  {
    if (!auth()->user()->can('galleries.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->galleriesFilter->filter($this->request->getPost('filters'));

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
      'galleries'         => $this->galleriesFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->galleriesFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new gallery" form.
   */
  public function create()
  {
    if (!auth()->user()->can('galleries.create')) {
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
   * Display the Edit form for a single gallery.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $galleriesModel = model($this->modelPrefix . 'GalleriesModel');

    $gallery = $galleriesModel->withDeleted()->find($pageId);
    if ($gallery === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Galleries.gallery')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'gallery'   => $gallery,
      'adminLink' => $this->adminLink,
      'types' => $this->types,
    ]);
  }

  /**
   * Creates new or saves an edited a gallery.
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

    if (!auth()->user()->can('galleries.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $galleriesModel = model($this->modelPrefix . 'GalleriesModel');

    $gallery = $pageId !== null
      ? $galleriesModel->find($pageId)
      : $galleriesModel->newPage();

    /** 
     * if there is a gallery id (so we run an update operation)
     * but such gallery is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($gallery === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Galleries.gallery')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $gallery->$key = $value;
    }

    if (!$gallery->file) {
      if ($gallery->type == 'IMAGE') {
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
          $newName = $file->getRandomName();
          $publicPath = 'uploads/';
          $file->move(FCPATH . $publicPath, $newName);
          $gallery->file = 'uploads/' . $newName;
        }
      }
    }

    /** attempt validate and save */

    if ($galleriesModel->save($gallery) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $galleriesModel->errors());
    }

    if (!isset($gallery->id) || !is_numeric(($gallery->id))) {
      $gallery->id = $galleriesModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $gallery->id))->with('message', lang('Bonfire.resourceSaved', [lang('Galleries.gallery')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('galleries.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $galleriesModel = model($this->modelPrefix . 'GalleriesModel');
    /** @var User|null $user */
    $gallery = $galleriesModel->find($pageId);

    if ($gallery === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Galleries.gallery')]));
    }

    if (!$galleriesModel->delete($gallery->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Galleries.gallery')]));
  }


  /** 
   * Deletes multiple galleries from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('galleries.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Galleries.galleries')]));
    }
    $ids = array_keys($ids);

    $galleriesModel = model($this->modelPrefix . 'GalleriesModel');

    if (!$galleriesModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Galleries.galleries')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $galleriesModel = model($this->modelPrefix . 'GalleriesModel');
    $validation = \Config\Services::validation();
    $validation->setRules($galleriesModel->getValidationRules(['only' => [$fieldName]]));
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
