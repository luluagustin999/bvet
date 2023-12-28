<?php

namespace App\Modules\Profile\Laboratorium\Bioteknologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class BioteknologiController extends AdminController
{
  protected $bioteknologiFilter;
  protected $bioteknologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Bioteknologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Bioteknologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->bioteknologiFilter = model($this->modelPrefix . 'BioteknologiFilter');
    $this->adminLink = (ADMIN_AREA . '/bioteknologi/');
  }

  /**
   * Display the "new bioteknologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('bioteknologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $bioteknologiModel = model($this->modelPrefix . 'BioteknologiModel');

    $bioteknologi = $bioteknologiModel->withDeleted()->find(1);
    if ($bioteknologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'bioteknologi'   => $bioteknologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a bioteknologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $bioteknologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('bioteknologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $bioteknologiModel = model($this->modelPrefix . 'BioteknologiModel');

    $bioteknologi = $bioteknologiId !== null
      ? $bioteknologiModel->find($bioteknologiId)
      : $bioteknologiModel->newBioteknologi();

    /** 
     * if there is a bioteknologi id (so we run an update operation)
     * but such bioteknologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($bioteknologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Bioteknologi.bioteknologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $bioteknologi->$key = $value;
    }

    /** attempt validate and save */

    $bioteknologi->title = lang('Bioteknologi.bioteknologiTitle');

    if ($bioteknologiModel->save($bioteknologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $bioteknologiModel->errors());
    }

    if (!isset($bioteknologi->id) || !is_numeric(($bioteknologi->id))) {
      $bioteknologi->id = $bioteknologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Bioteknologi.bioteknologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $bioteknologiModel = model($this->modelPrefix . 'BioteknologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($bioteknologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Bioteknologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
