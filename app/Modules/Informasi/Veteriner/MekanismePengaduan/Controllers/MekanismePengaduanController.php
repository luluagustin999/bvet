<?php

namespace App\Modules\Informasi\Veteriner\MekanismePengaduan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class MekanismePengaduanController extends AdminController
{
  protected $mekanismepengaduanFilter;
  protected $mekanismepengaduanModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\MekanismePengaduan\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\MekanismePengaduan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->mekanismepengaduanFilter = model($this->modelPrefix . 'MekanismePengaduanFilter');
    $this->adminLink = (ADMIN_AREA . '/mekanismepengaduan/');
  }

  public function list()
  {
    if (!auth()->user()->can('mekanismepengaduan.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->mekanismepengaduanFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->mekanismepengaduanFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('MekanismePengaduan.id'),
        'title'         => lang('MekanismePengaduan.title'),
        'excerpt'       => lang('MekanismePengaduan.excerpt'),
        'updated_at'    => lang('MekanismePengaduan.updated'),
      ],
      'showSelectAll' => true,
      'mekanismepengaduan'         => $this->mekanismepengaduanFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->mekanismepengaduanFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new mekanismepengaduan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('mekanismepengaduan.create')) {
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
   * Display the Edit form for a single mekanismepengaduan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');

    $mekanismepengaduan = $mekanismepengaduanModel->withDeleted()->find($pageId);
    if ($mekanismepengaduan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('MekanismePengaduan.mekanismepengaduan')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'mekanismepengaduan'   => $mekanismepengaduan,
      'adminLink' => $this->adminLink,
      'pageCategories' => $mekanismepengaduanModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a mekanismepengaduan.
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

    if (!auth()->user()->can('mekanismepengaduan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');

    $mekanismepengaduan = $pageId !== null
      ? $mekanismepengaduanModel->find($pageId)
      : $mekanismepengaduanModel->newPage();

    /** 
     * if there is a mekanismepengaduan id (so we run an update operation)
     * but such mekanismepengaduan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($mekanismepengaduan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('MekanismePengaduan.mekanismepengaduan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $mekanismepengaduan->$key = $value;
    }

    /** update slug if needed */
    $mekanismepengaduan->slug = $this->updateSlug($mekanismepengaduan->slug, $mekanismepengaduan->title, ($mekanismepengaduan->id ?? null));
    $mekanismepengaduan->excerpt = mb_substr(strip_tags($mekanismepengaduan->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $mekanismepengaduan->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($mekanismepengaduanModel->save($mekanismepengaduan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $mekanismepengaduanModel->errors());
    }

    if (!isset($mekanismepengaduan->id) || !is_numeric(($mekanismepengaduan->id))) {
      $mekanismepengaduan->id = $mekanismepengaduanModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $mekanismepengaduan->id))->with('message', lang('Bonfire.resourceSaved', [lang('MekanismePengaduan.mekanismepengaduan')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('mekanismepengaduan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');
    /** @var User|null $user */
    $mekanismepengaduan = $mekanismepengaduanModel->find($pageId);

    if ($mekanismepengaduan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('MekanismePengaduan.mekanismepengaduan')]));
    }

    if (!$mekanismepengaduanModel->delete($mekanismepengaduan->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('MekanismePengaduan.mekanismepengaduan')]));
  }


  /** 
   * Deletes multiple mekanismepengaduan from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('mekanismepengaduan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('MekanismePengaduan.mekanismepengaduan')]));
    }
    $ids = array_keys($ids);

    $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');

    if (!$mekanismepengaduanModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('MekanismePengaduan.mekanismepengaduan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');
    $validation = \Config\Services::validation();
    $validation->setRules($mekanismepengaduanModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with mekanismepengaduan slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $mekanismepengaduanModel = model($this->modelPrefix . 'MekanismePengaduanModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $mekanismepengaduanModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Veteriner\MekanismePengaduan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
