<?php

namespace App\Modules\Informasi\Veteriner\TataCara\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class TataCaraController extends AdminController
{
  protected $tatacaraFilter;
  protected $tatacaraModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\TataCara\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\TataCara\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->tatacaraFilter = model($this->modelPrefix . 'TataCaraFilter');
    $this->adminLink = (ADMIN_AREA . '/tatacara/');
  }

  public function list()
  {
    if (!auth()->user()->can('tatacara.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // Apply the search filter if a search query is provided
    if (!empty($searchQuery)) {
      $this->tatacaraFilter->like('title', $searchQuery);
    }

    // will need to replace next with 
    $this->tatacaraFilter->filter($this->request->getPost('filters'));



    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'id'            => lang('TataCara.id'),
        'title'         => lang('TataCara.title'),
        'excerpt'       => lang('TataCara.excerpt'),
        'updated_at'    => lang('TataCara.updated'),
      ],
      'showSelectAll' => true,
      'tatacara'         => $this->tatacaraFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->tatacaraFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new tatacara" form.
   */
  public function create()
  {
    if (!auth()->user()->can('tatacara.create')) {
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
   * Display the Edit form for a single tatacara.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');

    $tatacara = $tatacaraModel->withDeleted()->find($pageId);
    if ($tatacara === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('TataCara.tatacara')]));
    }

    $this->getTinyMCE();

    return $this->render($this->viewPrefix . 'form', [
      'tatacara'   => $tatacara,
      'adminLink' => $this->adminLink,
      'pageCategories' => $tatacaraModel->pageCategories,
    ]);
  }

  /**
   * Creates new or saves an edited a tatacara.
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

    if (!auth()->user()->can('tatacara.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');

    $tatacara = $pageId !== null
      ? $tatacaraModel->find($pageId)
      : $tatacaraModel->newPage();

    /** 
     * if there is a tatacara id (so we run an update operation)
     * but such tatacara is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($tatacara === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('TataCara.tatacara')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $tatacara->$key = $value;
    }

    /** update slug if needed */
    $tatacara->slug = $this->updateSlug($tatacara->slug, $tatacara->title, ($tatacara->id ?? null));
    $tatacara->excerpt = mb_substr(strip_tags($tatacara->content), 0, 100) . '...';

    $img = $this->request->getFile('image');

    if ($img->isValid() && !$img->hasMoved()) {
      $newName = $img->getRandomName();
      $publicPath = 'uploads/';
      $img->move(FCPATH . $publicPath, $newName);
      $tatacara->image = 'uploads/' . $newName;
    }

    /** attempt validate and save */

    if ($tatacaraModel->save($tatacara) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $tatacaraModel->errors());
    }

    if (!isset($tatacara->id) || !is_numeric(($tatacara->id))) {
      $tatacara->id = $tatacaraModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $tatacara->id))->with('message', lang('Bonfire.resourceSaved', [lang('TataCara.tatacara')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('tatacara.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');
    /** @var User|null $user */
    $tatacara = $tatacaraModel->find($pageId);

    if ($tatacara === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('TataCara.tatacara')]));
    }

    if (!$tatacaraModel->delete($tatacara->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('TataCara.tatacara')]));
  }


  /** 
   * Deletes multiple tatacara from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('tatacara.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('TataCara.tatacara')]));
    }
    $ids = array_keys($ids);

    $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');

    if (!$tatacaraModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('TataCara.tatacara')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');
    $validation = \Config\Services::validation();
    $validation->setRules($tatacaraModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }


  // deal with tatacara slug; geterate unique if needed; if it is supplied, do nothing
  private function updateSlug($inputSlug, $inputTitle, $inputId)
  {
    $sep = '-';
    if (is_null($inputSlug) || empty(trim($inputSlug))) {
      $tatacaraModel = model($this->modelPrefix . 'TataCaraModel');
      $pgId = $inputId ?? 0;
      $i = 0;
      $slug = mb_url_title($inputTitle, $sep, true);
      $list = $tatacaraModel->asArray()->select('slug')->like('slug', $slug, 'after')->where('id !=', $pgId)->findAll();
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
    $script = view('\App\Modules\Informasi\Veteriner\TataCara\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
