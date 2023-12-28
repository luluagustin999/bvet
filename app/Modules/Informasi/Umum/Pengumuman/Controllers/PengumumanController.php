<?php

namespace App\Modules\Informasi\Umum\Pengumuman\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PengumumanController extends AdminController
{
  protected $pengumumanFilter;
  protected $pengumumanModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Pengumuman\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Pengumuman\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pengumumanFilter = model($this->modelPrefix . 'PengumumanFilter');
    $this->adminLink = (ADMIN_AREA . '/pengumuman/');
  }

  public function list()
  {
    if (!auth()->user()->can('pengumuman.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->pengumumanFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->pengumumanFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('Pengumuman.id'),
        'title'         => lang('Pengumuman.title'),
        'excerpt'       => lang('Pengumuman.excerpt'),
        'updated_at'    => lang('Pengumuman.updated'),
      ],
      'showSelectAll' => true,
      'pengumuman'         => $this->pengumumanFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->pengumumanFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new pengumuman" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pengumuman.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    // TODO: transfer this to templates / views and make automatic
    // $viewMeta = service('viewMeta');
    // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Display the Edit form for a single pengumuman.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');

    $pengumuman = $pengumumanModel->withDeleted()->find($pageId);
    if ($pengumuman === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pengumuman.pengumuman')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'pengumuman'   => $pengumuman,
      'adminLink' => $this->adminLink,
      'pageCategories' => $pengumumanModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a pengumuman.
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

    if (!auth()->user()->can('pengumuman.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');

    $pengumuman = $pageId !== null
      ? $pengumumanModel->find($pageId)
      : $pengumumanModel->newPage();

    /** 
     * if there is a pengumuman id (so we run an update operation)
     * but such pengumuman is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pengumuman === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Pengumuman.pengumuman')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pengumuman->$key = $value;
    }

    /** update slug if needed */
    $pengumuman->slug = $this->updateSlug($pengumuman->slug, $pengumuman->title, ($pengumuman->id ?? null));
    $pengumuman->excerpt = mb_substr(strip_tags($pengumuman->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $pengumuman->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($pengumumanModel->save($pengumuman) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pengumumanModel->errors());
    }

    if (!isset($pengumuman->id) || !is_numeric(($pengumuman->id))) {
      $pengumuman->id = $pengumumanModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $pengumuman->id))->with('message', lang('Bonfire.resourceSaved', [lang('Pengumuman.pengumuman')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('pengumuman.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');
    /** @var User|null $user */
    $pengumuman = $pengumumanModel->find($pageId);

    if ($pengumuman === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pengumuman.pengumuman')]));
    }

    if (!$pengumumanModel->delete($pengumuman->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Pengumuman.pengumuman')]));
  }


  /** 
   * Deletes multiple pengumuman from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('pengumuman.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Pengumuman.pengumuman')]));
    }
    $ids = array_keys($ids);

    $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');

    if (!$pengumumanModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Pengumuman.pengumuman')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pengumumanModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with pengumuman slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $pengumumanModel = model($this->modelPrefix . 'PengumumanModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $pengumumanModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
      $flatList = $this->flattenArray($list, 'slug');
      // TODO: rewrite with text helper increment_string('file-4') function ?
      if (in_array($slug, $flatList)) {
        $i++;
        while (in_array($slug . $sep . $i, $flatList)) {
          $i++;
        }
      }

      return $i > 0 ? ($slug . $sep . $i) : $slug;
    }
    return $inputSlug;
  }

  private function flattenArray($array, $key)
  {
    $result = array();
    foreach ($array as $subarray) {
      $result[] = $subarray[$key];
    }
    return $result;
  }

  private function getTinyMCE()
  {

    $viewMeta = service('viewMeta');
    $viewMeta->addScript([
      'src' => site_url('/libs/tinymce/tinymce.min.js'),
      'referrerpolicy' => 'origin'
    ]);
    $script = view('\App\Modules\Informasi\Umum\Pengumuman\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
