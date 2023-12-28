<?php

namespace App\Modules\Profile\Laboratorium\Epidimiologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class EpidimiologiController extends AdminController
{
  protected $epidimiologiFilter;
  protected $epidimiologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Epidimiologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Epidimiologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->epidimiologiFilter = model($this->modelPrefix . 'EpidimiologiFilter');
    $this->adminLink = (ADMIN_AREA . '/epidimiologi/');
  }

  /**
   * Display the "new epidimiologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('epidimiologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $epidimiologiModel = model($this->modelPrefix . 'EpidimiologiModel');

    $epidimiologi = $epidimiologiModel->withDeleted()->find(1);
    if ($epidimiologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'epidimiologi'   => $epidimiologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a epidimiologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $epidimiologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('epidimiologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $epidimiologiModel = model($this->modelPrefix . 'EpidimiologiModel');

    $epidimiologi = $epidimiologiId !== null
      ? $epidimiologiModel->find($epidimiologiId)
      : $epidimiologiModel->newEpidimiologi();

    /** 
     * if there is a epidimiologi id (so we run an update operation)
     * but such epidimiologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($epidimiologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Epidimiologi.epidimiologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $epidimiologi->$key = $value;
    }

    /** attempt validate and save */

    $epidimiologi->title = lang('Epidimiologi.epidimiologiTitle');

    if ($epidimiologiModel->save($epidimiologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $epidimiologiModel->errors());
    }

    if (!isset($epidimiologi->id) || !is_numeric(($epidimiologi->id))) {
      $epidimiologi->id = $epidimiologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Epidimiologi.epidimiologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $epidimiologiModel = model($this->modelPrefix . 'EpidimiologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($epidimiologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Epidimiologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
