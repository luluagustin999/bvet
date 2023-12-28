<?php

namespace App\Modules\Pages\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PagesController extends AdminController
{
  protected $pagesFilter;
  protected $pagesModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Pages\Views\\';
  protected $modelPrefix = 'App\Modules\Pages\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pagesFilter = model($this->modelPrefix . 'PagesFilter');
    $this->adminLink = (ADMIN_AREA . '/pages/');
  }

  /**
   * Display the "new page" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pages.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $pagesModel = model($this->modelPrefix . 'PagesModel');

    $page = $pagesModel->withDeleted()->find(1);
    if ($page === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'page'   => $page,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a page.
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
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('pages.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pagesModel = model($this->modelPrefix . 'PagesModel');

    $page = $pageId !== null
      ? $pagesModel->find($pageId)
      : $pagesModel->newPage();

    /** 
     * if there is a page id (so we run an update operation)
     * but such page is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($page === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Pages.page')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $page->$key = $value;
    }

    /** attempt validate and save */

    $page->title = lang('Pages.pageTitle');

    if ($pagesModel->save($page) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pagesModel->errors());
    }

    if (!isset($page->id) || !is_numeric(($page->id))) {
      $page->id = $pagesModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Pages.page')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pagesModel = model($this->modelPrefix . 'PagesModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pagesModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }

  private function getTinyMCE()
  {

    $viewMeta = service('viewMeta');
    $viewMeta->addScript([
      'src' => site_url('/libs/tinymce/tinymce.min.js'),
      'referrerpolicy' => 'origin'
    ]);
    $script = view('\App\Modules\Pages\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
