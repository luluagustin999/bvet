<?php

namespace App\Modules\Informasi\Umum\Berita\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class BeritaController extends AdminController
{
  protected $beritaFilter;
  protected $beritaModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Berita\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Berita\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->beritaFilter = model($this->modelPrefix . 'BeritaFilter');
    $this->adminLink = (ADMIN_AREA . '/berita/');
  }

  public function list()
  {
    if (!auth()->user()->can('berita.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->beritaFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->beritaFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('Berita.id'),
        'title'         => lang('Berita.title'),
        'excerpt'       => lang('Berita.excerpt'),
        'updated_at'    => lang('Berita.updated'),
      ],
      'showSelectAll' => true,
      'berita'         => $this->beritaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->beritaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new berita" form.
   */
  public function create()
  {
    if (!auth()->user()->can('berita.create')) {
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
   * Display the Edit form for a single berita.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $beritaModel = model($this->modelPrefix . 'BeritaModel');

    $berita = $beritaModel->withDeleted()->find($pageId);
    if ($berita === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Berita.berita')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'berita'   => $berita,
      'adminLink' => $this->adminLink,
      'pageCategories' => $beritaModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a berita.
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

    if (!auth()->user()->can('berita.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $beritaModel = model($this->modelPrefix . 'BeritaModel');

    $berita = $pageId !== null
      ? $beritaModel->find($pageId)
      : $beritaModel->newPage();

    /** 
     * if there is a berita id (so we run an update operation)
     * but such berita is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($berita === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Berita.berita')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $berita->$key = $value;
    }

    /** update slug if needed */
    $berita->slug = $this->updateSlug($berita->slug, $berita->title, ($berita->id ?? null));
    $berita->excerpt = mb_substr(strip_tags($berita->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $berita->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($beritaModel->save($berita) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $beritaModel->errors());
    }

    if (!isset($berita->id) || !is_numeric(($berita->id))) {
      $berita->id = $beritaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $berita->id))->with('message', lang('Bonfire.resourceSaved', [lang('Berita.berita')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('berita.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $beritaModel = model($this->modelPrefix . 'BeritaModel');
    /** @var User|null $user */
    $berita = $beritaModel->find($pageId);

    if ($berita === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Berita.berita')]));
    }

    if (!$beritaModel->delete($berita->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Berita.berita')]));
  }


  /** 
   * Deletes multiple berita from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('berita.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Berita.berita')]));
    }
    $ids = array_keys($ids);

    $beritaModel = model($this->modelPrefix . 'BeritaModel');

    if (!$beritaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Berita.berita')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $beritaModel = model($this->modelPrefix . 'BeritaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($beritaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with berita slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $beritaModel = model($this->modelPrefix . 'BeritaModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $beritaModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Umum\Berita\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
