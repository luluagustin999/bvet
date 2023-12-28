<?php

namespace App\Modules\Informasi\Veteriner\SertifikatHasil\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class SertifikatHasilController extends AdminController
{
  protected $sertifikathasilFilter;
  protected $sertifikathasilModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\SertifikatHasil\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\SertifikatHasil\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->sertifikathasilFilter = model($this->modelPrefix . 'SertifikatHasilFilter');
    $this->adminLink = (ADMIN_AREA . '/sertifikathasil/');
  }

  /**
   * Display the "new sertifikathasil" form.
   */
  public function create()
  {
    if (!auth()->user()->can('sertifikathasil.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $sertifikathasilModel = model($this->modelPrefix . 'SertifikatHasilModel');

    $sertifikathasil = $sertifikathasilModel->withDeleted()->find(1);
    if ($sertifikathasil === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'sertifikathasil'   => $sertifikathasil,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a sertifikathasil.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $sertifikathasilId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('sertifikathasil.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $sertifikathasilModel = model($this->modelPrefix . 'SertifikatHasilModel');

    $sertifikathasil = $sertifikathasilId !== null
      ? $sertifikathasilModel->find($sertifikathasilId)
      : $sertifikathasilModel->newSertifikatHasil();

    /** 
     * if there is a sertifikathasil id (so we run an update operation)
     * but such sertifikathasil is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($sertifikathasil === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('SertifikatHasil.sertifikathasil')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $sertifikathasil->$key = $value;
    }

    /** attempt validate and save */

    $sertifikathasil->title = lang('SertifikatHasil.sertifikathasilTitle');

    if ($sertifikathasilModel->save($sertifikathasil) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $sertifikathasilModel->errors());
    }

    if (!isset($sertifikathasil->id) || !is_numeric(($sertifikathasil->id))) {
      $sertifikathasil->id = $sertifikathasilModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('SertifikatHasil.sertifikathasil')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $sertifikathasilModel = model($this->modelPrefix . 'SertifikatHasilModel');
    $validation = \Config\Services::validation();
    $validation->setRules($sertifikathasilModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Informasi\Veteriner\SertifikatHasil\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
