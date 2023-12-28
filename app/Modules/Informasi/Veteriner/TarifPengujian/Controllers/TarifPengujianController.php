<?php

namespace App\Modules\Informasi\Veteriner\TarifPengujian\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class TarifPengujianController extends AdminController
{
  protected $tarifpengujianFilter;
  protected $tarifpengujianModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\TarifPengujian\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\TarifPengujian\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->tarifpengujianFilter = model($this->modelPrefix . 'TarifPengujianFilter');
    $this->adminLink = (ADMIN_AREA . '/tarifpengujian/');
  }

  public function list()
  {
    if (!auth()->user()->can('tarifpengujian.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->tarifpengujianFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->tarifpengujianFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('TarifPengujian.id'),
        'title'         => lang('TarifPengujian.title'),
        'excerpt'       => lang('TarifPengujian.excerpt'),
        'updated_at'    => lang('TarifPengujian.updated'),
      ],
      'showSelectAll' => true,
      'tarifpengujian'         => $this->tarifpengujianFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->tarifpengujianFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new tarifpengujian" form.
   */
  public function create()
  {
    if (!auth()->user()->can('tarifpengujian.create')) {
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
   * Display the Edit form for a single tarifpengujian.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');

    $tarifpengujian = $tarifpengujianModel->withDeleted()->find($pageId);
    if ($tarifpengujian === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('TarifPengujian.tarifpengujian')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'tarifpengujian'   => $tarifpengujian,
      'adminLink' => $this->adminLink,
      'pageCategories' => $tarifpengujianModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a tarifpengujian.
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

    if (!auth()->user()->can('tarifpengujian.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');

    $tarifpengujian = $pageId !== null
      ? $tarifpengujianModel->find($pageId)
      : $tarifpengujianModel->newPage();

    /** 
     * if there is a tarifpengujian id (so we run an update operation)
     * but such tarifpengujian is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($tarifpengujian === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('TarifPengujian.tarifpengujian')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $tarifpengujian->$key = $value;
    }

    /** update slug if needed */
    $tarifpengujian->slug = $this->updateSlug($tarifpengujian->slug, $tarifpengujian->title, ($tarifpengujian->id ?? null));
    $tarifpengujian->excerpt = mb_substr(strip_tags($tarifpengujian->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $tarifpengujian->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($tarifpengujianModel->save($tarifpengujian) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $tarifpengujianModel->errors());
    }

    if (!isset($tarifpengujian->id) || !is_numeric(($tarifpengujian->id))) {
      $tarifpengujian->id = $tarifpengujianModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $tarifpengujian->id))->with('message', lang('Bonfire.resourceSaved', [lang('TarifPengujian.tarifpengujian')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('tarifpengujian.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');
    /** @var User|null $user */
    $tarifpengujian = $tarifpengujianModel->find($pageId);

    if ($tarifpengujian === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('TarifPengujian.tarifpengujian')]));
    }

    if (!$tarifpengujianModel->delete($tarifpengujian->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('TarifPengujian.tarifpengujian')]));
  }


  /** 
   * Deletes multiple tarifpengujian from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('tarifpengujian.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('TarifPengujian.tarifpengujian')]));
    }
    $ids = array_keys($ids);

    $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');

    if (!$tarifpengujianModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('TarifPengujian.tarifpengujian')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');
    $validation = \Config\Services::validation();
    $validation->setRules($tarifpengujianModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with tarifpengujian slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $tarifpengujianModel = model($this->modelPrefix . 'TarifPengujianModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $tarifpengujianModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Veteriner\TarifPengujian\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
