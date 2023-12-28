<?php

namespace App\Modules\Informasi\Umum\Pelayanan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PelayananController extends AdminController
{
  protected $pelayananFilter;
  protected $pelayananModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Pelayanan\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Pelayanan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pelayananFilter = model($this->modelPrefix . 'PelayananFilter');
    $this->adminLink = (ADMIN_AREA . '/pelayanan/');
  }

  public function list()
  {
    if (!auth()->user()->can('pelayanan.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->pelayananFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->pelayananFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('Pelayanan.id'),
        'title'         => lang('Pelayanan.title'),
        'excerpt'       => lang('Pelayanan.excerpt'),
        'updated_at'    => lang('Pelayanan.updated'),
      ],
      'showSelectAll' => true,
      'pelayanan'         => $this->pelayananFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->pelayananFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new pelayanan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pelayanan.create')) {
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
   * Display the Edit form for a single pelayanan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $pelayananModel = model($this->modelPrefix . 'PelayananModel');

    $pelayanan = $pelayananModel->withDeleted()->find($pageId);
    if ($pelayanan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pelayanan.pelayanan')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'pelayanan'   => $pelayanan,
      'adminLink' => $this->adminLink,
      'pageCategories' => $pelayananModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a pelayanan.
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

    if (!auth()->user()->can('pelayanan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pelayananModel = model($this->modelPrefix . 'PelayananModel');

    $pelayanan = $pageId !== null
      ? $pelayananModel->find($pageId)
      : $pelayananModel->newPage();

    /** 
     * if there is a pelayanan id (so we run an update operation)
     * but such pelayanan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pelayanan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Pelayanan.pelayanan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pelayanan->$key = $value;
    }

    /** update slug if needed */
    $pelayanan->slug = $this->updateSlug($pelayanan->slug, $pelayanan->title, ($pelayanan->id ?? null));
    $pelayanan->excerpt = mb_substr(strip_tags($pelayanan->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $pelayanan->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($pelayananModel->save($pelayanan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pelayananModel->errors());
    }

    if (!isset($pelayanan->id) || !is_numeric(($pelayanan->id))) {
      $pelayanan->id = $pelayananModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $pelayanan->id))->with('message', lang('Bonfire.resourceSaved', [lang('Pelayanan.pelayanan')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('pelayanan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $pelayananModel = model($this->modelPrefix . 'PelayananModel');
    /** @var User|null $user */
    $pelayanan = $pelayananModel->find($pageId);

    if ($pelayanan === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Pelayanan.pelayanan')]));
    }

    if (!$pelayananModel->delete($pelayanan->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Pelayanan.pelayanan')]));
  }


  /** 
   * Deletes multiple pelayanan from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('pelayanan.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Pelayanan.pelayanan')]));
    }
    $ids = array_keys($ids);

    $pelayananModel = model($this->modelPrefix . 'PelayananModel');

    if (!$pelayananModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Pelayanan.pelayanan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pelayananModel = model($this->modelPrefix . 'PelayananModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pelayananModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with pelayanan slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $pelayananModel = model($this->modelPrefix . 'PelayananModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $pelayananModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Umum\Pelayanan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
