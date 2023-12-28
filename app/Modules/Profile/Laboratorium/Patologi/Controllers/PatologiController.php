<?php

namespace App\Modules\Profile\Laboratorium\Patologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PatologiController extends AdminController
{
  protected $patologiFilter;
  protected $patologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Patologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Patologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->patologiFilter = model($this->modelPrefix . 'PatologiFilter');
    $this->adminLink = (ADMIN_AREA . '/patologi/');
  }

  /**
   * Display the "new patologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('patologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $patologiModel = model($this->modelPrefix . 'PatologiModel');

    $patologi = $patologiModel->withDeleted()->find(1);
    if ($patologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'patologi'   => $patologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a patologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $patologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('patologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $patologiModel = model($this->modelPrefix . 'PatologiModel');

    $patologi = $patologiId !== null
      ? $patologiModel->find($patologiId)
      : $patologiModel->newPatologi();

    /** 
     * if there is a patologi id (so we run an update operation)
     * but such patologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($patologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Patologi.patologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $patologi->$key = $value;
    }

    /** attempt validate and save */

    $patologi->title = lang('Patologi.patologiTitle');

    if ($patologiModel->save($patologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $patologiModel->errors());
    }

    if (!isset($patologi->id) || !is_numeric(($patologi->id))) {
      $patologi->id = $patologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Patologi.patologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $patologiModel = model($this->modelPrefix . 'PatologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($patologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Patologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
