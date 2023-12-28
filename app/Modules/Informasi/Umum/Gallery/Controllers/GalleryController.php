<?php

namespace App\Modules\Informasi\Umum\Gallery\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class GalleryController extends AdminController
{
  protected $galleryFilter;
  protected $galleryModel;
  protected $adminLink;
  protected $types;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Gallery\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Gallery\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->galleryFilter = model($this->modelPrefix . 'GalleryFilter');
    $this->adminLink = (ADMIN_AREA . '/gallery/');
    $this->types = ['IMAGE', 'VIDEO'];
  }

  public function list()
  {
    if (!auth()->user()->can('gallery.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->galleryFilter->filter($this->request->getPost('filters'));

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
      'gallery'         => $this->galleryFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->galleryFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new gallery" form.
   */
  public function create()
  {
    if (!auth()->user()->can('gallery.create')) {
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

    $galleryModel = model($this->modelPrefix . 'GalleryModel');

    $gallery = $galleryModel->withDeleted()->find($pageId);
    if ($gallery === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Gallery.gallery')]));
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

    if (!auth()->user()->can('gallery.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $galleryModel = model($this->modelPrefix . 'GalleryModel');

    $gallery = $pageId !== null
      ? $galleryModel->find($pageId)
      : $galleryModel->newPage();

    /** 
     * if there is a gallery id (so we run an update operation)
     * but such gallery is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($gallery === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Gallery.gallery')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $gallery->$key = $value;
    }

    if ($gallery->type == 'IMAGE') {
      $file = $this->request->getFile('file');

      if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $publicPath = 'uploads/';
        $file->move(FCPATH . $publicPath, $newName);
        $gallery->file = 'uploads/' . $newName;
      }
    }

    /** attempt validate and save */

    if ($galleryModel->save($gallery) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $galleryModel->errors());
    }

    if (!isset($gallery->id) || !is_numeric(($gallery->id))) {
      $gallery->id = $galleryModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $gallery->id))->with('message', lang('Bonfire.resourceSaved', [lang('Gallery.gallery')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('gallery.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $galleryModel = model($this->modelPrefix . 'GalleryModel');
    /** @var User|null $user */
    $gallery = $galleryModel->find($pageId);

    if ($gallery === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Gallery.gallery')]));
    }

    if (!$galleryModel->delete($gallery->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Gallery.gallery')]));
  }


  /** 
   * Deletes multiple gallery from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('gallery.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Gallery.gallery')]));
    }
    $ids = array_keys($ids);

    $galleryModel = model($this->modelPrefix . 'GalleryModel');

    if (!$galleryModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Gallery.gallery')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $galleryModel = model($this->modelPrefix . 'GalleryModel');
    $validation = \Config\Services::validation();
    $validation->setRules($galleryModel->getValidationRules(['only' => [$fieldName]]));
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
