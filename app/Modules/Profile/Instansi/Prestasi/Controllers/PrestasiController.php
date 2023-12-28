<?php

namespace App\Modules\Profile\Instansi\Prestasi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PrestasiController extends AdminController
{
  protected $prestasiFilter;
  protected $prestasiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\Prestasi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Prestasi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->prestasiFilter = model($this->modelPrefix . 'PrestasiFilter');
    $this->adminLink = (ADMIN_AREA . '/prestasi/');
  }

  /**
   * Display the "new prestasi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('prestasi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $prestasiModel = model($this->modelPrefix . 'PrestasiModel');

    $prestasi = $prestasiModel->withDeleted()->find(1);
    if ($prestasi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'prestasi'   => $prestasi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a prestasi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $prestasiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('prestasi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $prestasiModel = model($this->modelPrefix . 'PrestasiModel');

    $prestasi = $prestasiId !== null
      ? $prestasiModel->find($prestasiId)
      : $prestasiModel->newPrestasi();

    /** 
     * if there is a prestasi id (so we run an update operation)
     * but such prestasi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($prestasi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Prestasi.prestasi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $prestasi->$key = $value;
    }

    /** attempt validate and save */

    $prestasi->title = lang('Prestasi.prestasiTitle');

    if ($prestasiModel->save($prestasi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $prestasiModel->errors());
    }

    if (!isset($prestasi->id) || !is_numeric(($prestasi->id))) {
      $prestasi->id = $prestasiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Prestasi.prestasi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $prestasiModel = model($this->modelPrefix . 'PrestasiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($prestasiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\Prestasi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
