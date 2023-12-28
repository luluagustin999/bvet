<?php

namespace App\Modules\Informasi\Veteriner\AlurPersyaratan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class AlurPersyaratanController extends AdminController
{
  protected $alurpersyaratanFilter;
  protected $alurpersyaratanModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\AlurPersyaratan\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\AlurPersyaratan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->alurpersyaratanFilter = model($this->modelPrefix . 'AlurPersyaratanFilter');
    $this->adminLink = (ADMIN_AREA . '/alurpersyaratan/');
  }

  public function list()
  {
    if (!auth()->user()->can('alurpersyaratan.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->alurpersyaratanFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->alurpersyaratanFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('AlurPersyaratan.id'),
        'title'         => lang('AlurPersyaratan.title'),
        'excerpt'       => lang('AlurPersyaratan.excerpt'),
        'updated_at'    => lang('AlurPersyaratan.updated'),
      ],
      'showSelectAll' => true,
      'alurpersyaratan'         => $this->alurpersyaratanFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->alurpersyaratanFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new alurpersyaratan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('alurpersyaratan.create')) {
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
   * Display the Edit form for a single alurpersyaratan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');

    $alurpersyaratan = $alurpersyaratanModel->withDeleted()->find($pageId);
    if ($alurpersyaratan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('AlurPersyaratan.alurpersyaratan')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'alurpersyaratan'   => $alurpersyaratan,
      'adminLink' => $this->adminLink,
      'pageCategories' => $alurpersyaratanModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a alurpersyaratan.
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

    if (!auth()->user()->can('alurpersyaratan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');

    $alurpersyaratan = $pageId !== null
      ? $alurpersyaratanModel->find($pageId)
      : $alurpersyaratanModel->newPage();

    /** 
     * if there is a alurpersyaratan id (so we run an update operation)
     * but such alurpersyaratan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($alurpersyaratan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('AlurPersyaratan.alurpersyaratan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $alurpersyaratan->$key = $value;
    }

    /** update slug if needed */
    $alurpersyaratan->slug = $this->updateSlug($alurpersyaratan->slug, $alurpersyaratan->title, ($alurpersyaratan->id ?? null));
    $alurpersyaratan->excerpt = mb_substr(strip_tags($alurpersyaratan->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $alurpersyaratan->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($alurpersyaratanModel->save($alurpersyaratan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $alurpersyaratanModel->errors());
    }

    if (!isset($alurpersyaratan->id) || !is_numeric(($alurpersyaratan->id))) {
      $alurpersyaratan->id = $alurpersyaratanModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $alurpersyaratan->id))->with('message', lang('Bonfire.resourceSaved', [lang('AlurPersyaratan.alurpersyaratan')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('alurpersyaratan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');
    /** @var User|null $user */
    $alurpersyaratan = $alurpersyaratanModel->find($pageId);

    if ($alurpersyaratan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('AlurPersyaratan.alurpersyaratan')]));
    }

    if (!$alurpersyaratanModel->delete($alurpersyaratan->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('AlurPersyaratan.alurpersyaratan')]));
  }


  /** 
   * Deletes multiple alurpersyaratan from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('alurpersyaratan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('AlurPersyaratan.alurpersyaratan')]));
    }
    $ids = array_keys($ids);

    $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');

    if (!$alurpersyaratanModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('AlurPersyaratan.alurpersyaratan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');
    $validation = \Config\Services::validation();
    $validation->setRules($alurpersyaratanModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with alurpersyaratan slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $alurpersyaratanModel = model($this->modelPrefix . 'AlurPersyaratanModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $alurpersyaratanModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Veteriner\AlurPersyaratan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
