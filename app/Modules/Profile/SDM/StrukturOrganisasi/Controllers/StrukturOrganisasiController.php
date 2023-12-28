<?php

namespace App\Modules\Profile\SDM\StrukturOrganisasi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class StrukturOrganisasiController extends AdminController
{
  protected $strukturorganisasiFilter;
  protected $strukturorganisasiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\SDM\StrukturOrganisasi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\SDM\StrukturOrganisasi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->strukturorganisasiFilter = model($this->modelPrefix . 'StrukturOrganisasiFilter');
    $this->adminLink = (ADMIN_AREA . '/strukturorganisasi/');
  }

  /**
   * Display the "new strukturorganisasi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('strukturorganisasi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $strukturorganisasiModel = model($this->modelPrefix . 'StrukturOrganisasiModel');

    $strukturorganisasi = $strukturorganisasiModel->withDeleted()->find(1);
    if ($strukturorganisasi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'strukturorganisasi'   => $strukturorganisasi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a strukturorganisasi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $strukturorganisasiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('strukturorganisasi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $strukturorganisasiModel = model($this->modelPrefix . 'StrukturOrganisasiModel');

    $strukturorganisasi = $strukturorganisasiId !== null
      ? $strukturorganisasiModel->find($strukturorganisasiId)
      : $strukturorganisasiModel->newStrukturOrganisasi();

    /** 
     * if there is a strukturorganisasi id (so we run an update operation)
     * but such strukturorganisasi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($strukturorganisasi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('StrukturOrganisasi.strukturorganisasi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $strukturorganisasi->$key = $value;
    }

    /** attempt validate and save */

    $strukturorganisasi->title = lang('StrukturOrganisasi.strukturorganisasiTitle');

    if ($strukturorganisasiModel->save($strukturorganisasi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $strukturorganisasiModel->errors());
    }

    if (!isset($strukturorganisasi->id) || !is_numeric(($strukturorganisasi->id))) {
      $strukturorganisasi->id = $strukturorganisasiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('StrukturOrganisasi.strukturorganisasi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $strukturorganisasiModel = model($this->modelPrefix . 'StrukturOrganisasiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($strukturorganisasiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\SDM\StrukturOrganisasi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
