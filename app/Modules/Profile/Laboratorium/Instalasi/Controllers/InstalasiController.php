<?php

namespace App\Modules\Profile\Laboratorium\Instalasi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class InstalasiController extends AdminController
{
  protected $instalasiFilter;
  protected $instalasiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Instalasi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Instalasi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->instalasiFilter = model($this->modelPrefix . 'InstalasiFilter');
    $this->adminLink = (ADMIN_AREA . '/instalasi/');
  }

  /**
   * Display the "new instalasi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('instalasi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $instalasiModel = model($this->modelPrefix . 'InstalasiModel');

    $instalasi = $instalasiModel->withDeleted()->find(1);
    if ($instalasi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'instalasi'   => $instalasi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a instalasi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $instalasiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('instalasi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $instalasiModel = model($this->modelPrefix . 'InstalasiModel');

    $instalasi = $instalasiId !== null
      ? $instalasiModel->find($instalasiId)
      : $instalasiModel->newInstalasi();

    /** 
     * if there is a instalasi id (so we run an update operation)
     * but such instalasi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($instalasi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Instalasi.instalasi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $instalasi->$key = $value;
    }

    /** attempt validate and save */

    $instalasi->title = lang('Instalasi.instalasiTitle');

    if ($instalasiModel->save($instalasi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $instalasiModel->errors());
    }

    if (!isset($instalasi->id) || !is_numeric(($instalasi->id))) {
      $instalasi->id = $instalasiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Instalasi.instalasi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $instalasiModel = model($this->modelPrefix . 'InstalasiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($instalasiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Instalasi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
