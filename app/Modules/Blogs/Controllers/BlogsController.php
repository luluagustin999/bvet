<?php

namespace App\Modules\Blogs\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class BlogsController extends AdminController
{
  protected $blogsFilter;
  protected $blogsModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Blogs\Views\\';
  protected $modelPrefix = 'App\Modules\Blogs\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->blogsFilter = model($this->modelPrefix . 'BlogsFilter');
    $this->adminLink = (ADMIN_AREA . '/blogs/');
  }

  public function list()
  {
    if (!auth()->user()->can('blogs.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->blogsFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->blogsFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('Blogs.id'),
        'title'         => lang('Blogs.title'),
        'excerpt'       => lang('Blogs.excerpt'),
        'updated_at'    => lang('Blogs.updated'),
      ],
      'showSelectAll' => true,
      'blogs'         => $this->blogsFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->blogsFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new blog" form.
   */
  public function create()
  {
    if (!auth()->user()->can('blogs.create')) {
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
   * Display the Edit form for a single blog.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $blogsModel = model($this->modelPrefix . 'BlogsModel');

    $blog = $blogsModel->withDeleted()->find($pageId);
    if ($blog === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Blogs.blog')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'blog'   => $blog,
      'adminLink' => $this->adminLink,
      'pageCategories' => $blogsModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a blog.
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

    if (!auth()->user()->can('blogs.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $blogsModel = model($this->modelPrefix . 'BlogsModel');

    $blog = $pageId !== null
      ? $blogsModel->find($pageId)
      : $blogsModel->newPage();

    /** 
     * if there is a blog id (so we run an update operation)
     * but such blog is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($blog === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Blogs.blog')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $blog->$key = $value;
    }

    /** update slug if needed */
    $blog->slug = $this->updateSlug($blog->slug, $blog->title, ($blog->id ?? null));
    $blog->excerpt = mb_substr(strip_tags($blog->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $blog->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($blogsModel->save($blog) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $blogsModel->errors());
    }

    if (!isset($blog->id) || !is_numeric(($blog->id))) {
      $blog->id = $blogsModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $blog->id))->with('message', lang('Bonfire.resourceSaved', [lang('Blogs.blog')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('blogs.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $blogsModel = model($this->modelPrefix . 'BlogsModel');
    /** @var User|null $user */
    $blog = $blogsModel->find($pageId);

    if ($blog === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Blogs.blog')]));
    }

    if (!$blogsModel->delete($blog->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Blogs.blog')]));
  }


  /** 
   * Deletes multiple blogs from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('blogs.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Blogs.blogs')]));
    }
    $ids = array_keys($ids);

    $blogsModel = model($this->modelPrefix . 'BlogsModel');

    if (!$blogsModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Blogs.blogs')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $blogsModel = model($this->modelPrefix . 'BlogsModel');
    $validation = \Config\Services::validation();
    $validation->setRules($blogsModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with blog slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $blogsModel = model($this->modelPrefix . 'BlogsModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $blogsModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Blogs\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
