<?php

namespace App\Modules\Profile\SDM\DataPegawai\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class DataPegawaiController extends AdminController
{
  protected $datapegawaiFilter;
  protected $datapegawaiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\SDM\DataPegawai\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\SDM\DataPegawai\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->datapegawaiFilter = model($this->modelPrefix . 'DataPegawaiFilter');
    $this->adminLink = (ADMIN_AREA . '/datapegawai/');
  }

  /**
   * Display the "new datapegawai" form.
   */
  public function create()
  {
    if (!auth()->user()->can('datapegawai.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $datapegawaiModel = model($this->modelPrefix . 'DataPegawaiModel');

    $datapegawai = $datapegawaiModel->withDeleted()->find(1);
    if ($datapegawai === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'datapegawai'   => $datapegawai,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a datapegawai.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $datapegawaiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('datapegawai.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $datapegawaiModel = model($this->modelPrefix . 'DataPegawaiModel');

    $datapegawai = $datapegawaiId !== null
      ? $datapegawaiModel->find($datapegawaiId)
      : $datapegawaiModel->newDataPegawai();

    /** 
     * if there is a datapegawai id (so we run an update operation)
     * but such datapegawai is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($datapegawai === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('DataPegawai.datapegawai')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $datapegawai->$key = $value;
    }

    /** attempt validate and save */

    $datapegawai->title = lang('DataPegawai.datapegawaiTitle');

    if ($datapegawaiModel->save($datapegawai) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $datapegawaiModel->errors());
    }

    if (!isset($datapegawai->id) || !is_numeric(($datapegawai->id))) {
      $datapegawai->id = $datapegawaiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('DataPegawai.datapegawai')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $datapegawaiModel = model($this->modelPrefix . 'DataPegawaiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($datapegawaiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\SDM\DataPegawai\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
