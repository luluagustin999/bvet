<?php

namespace App\Modules\Profile\Instansi\MaklumatPelayanan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class MaklumatPelayananController extends AdminController
{
  protected $maklumatpelayananFilter;
  protected $maklumatpelayananModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\MaklumatPelayanan\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\MaklumatPelayanan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->maklumatpelayananFilter = model($this->modelPrefix . 'MaklumatPelayananFilter');
    $this->adminLink = (ADMIN_AREA . '/maklumatpelayanan/');
  }

  /**
   * Display the "new maklumatpelayanan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('maklumatpelayanan.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $maklumatpelayananModel = model($this->modelPrefix . 'MaklumatPelayananModel');

    $maklumatpelayanan = $maklumatpelayananModel->withDeleted()->find(1);
    if ($maklumatpelayanan === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'maklumatpelayanan'   => $maklumatpelayanan,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a maklumatpelayanan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $maklumatpelayananId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('maklumatpelayanan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $maklumatpelayananModel = model($this->modelPrefix . 'MaklumatPelayananModel');

    $maklumatpelayanan = $maklumatpelayananId !== null
      ? $maklumatpelayananModel->find($maklumatpelayananId)
      : $maklumatpelayananModel->newMaklumatPelayanan();

    /** 
     * if there is a maklumatpelayanan id (so we run an update operation)
     * but such maklumatpelayanan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($maklumatpelayanan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('MaklumatPelayanan.maklumatpelayanan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $maklumatpelayanan->$key = $value;
    }

    /** attempt validate and save */

    $maklumatpelayanan->title = lang('MaklumatPelayanan.maklumatpelayananTitle');

    if ($maklumatpelayananModel->save($maklumatpelayanan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $maklumatpelayananModel->errors());
    }

    if (!isset($maklumatpelayanan->id) || !is_numeric(($maklumatpelayanan->id))) {
      $maklumatpelayanan->id = $maklumatpelayananModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('MaklumatPelayanan.maklumatpelayanan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $maklumatpelayananModel = model($this->modelPrefix . 'MaklumatPelayananModel');
    $validation = \Config\Services::validation();
    $validation->setRules($maklumatpelayananModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\MaklumatPelayanan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
