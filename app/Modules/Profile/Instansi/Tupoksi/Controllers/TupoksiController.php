<?php

namespace App\Modules\Profile\Instansi\Tupoksi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class TupoksiController extends AdminController
{
  protected $tupoksiFilter;
  protected $tupoksiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\Tupoksi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Tupoksi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->tupoksiFilter = model($this->modelPrefix . 'TupoksiFilter');
    $this->adminLink = (ADMIN_AREA . '/tupoksi/');
  }

  /**
   * Display the "new tupoksi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('tupoksi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $tupoksiModel = model($this->modelPrefix . 'TupoksiModel');

    $tupoksi = $tupoksiModel->withDeleted()->find(1);
    if ($tupoksi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'tupoksi'   => $tupoksi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a tupoksi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $tupoksiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('tupoksi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $tupoksiModel = model($this->modelPrefix . 'TupoksiModel');

    $tupoksi = $tupoksiId !== null
      ? $tupoksiModel->find($tupoksiId)
      : $tupoksiModel->newTupoksi();

    /** 
     * if there is a tupoksi id (so we run an update operation)
     * but such tupoksi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($tupoksi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Tupoksi.tupoksi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $tupoksi->$key = $value;
    }

    /** attempt validate and save */

    $tupoksi->title = lang('Tupoksi.tupoksiTitle');

    if ($tupoksiModel->save($tupoksi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $tupoksiModel->errors());
    }

    if (!isset($tupoksi->id) || !is_numeric(($tupoksi->id))) {
      $tupoksi->id = $tupoksiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Tupoksi.tupoksi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $tupoksiModel = model($this->modelPrefix . 'TupoksiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($tupoksiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\Tupoksi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
