<?php

namespace App\Modules\Profile\Laboratorium\Virologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class VirologiController extends AdminController
{
  protected $virologiFilter;
  protected $virologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Virologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Virologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->virologiFilter = model($this->modelPrefix . 'VirologiFilter');
    $this->adminLink = (ADMIN_AREA . '/virologi/');
  }

  /**
   * Display the "new virologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('virologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $virologiModel = model($this->modelPrefix . 'VirologiModel');

    $virologi = $virologiModel->withDeleted()->find(1);
    if ($virologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'virologi'   => $virologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a virologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $virologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('virologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $virologiModel = model($this->modelPrefix . 'VirologiModel');

    $virologi = $virologiId !== null
      ? $virologiModel->find($virologiId)
      : $virologiModel->newVirologi();

    /** 
     * if there is a virologi id (so we run an update operation)
     * but such virologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($virologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Virologi.virologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $virologi->$key = $value;
    }

    /** attempt validate and save */

    $virologi->title = lang('Virologi.virologiTitle');

    if ($virologiModel->save($virologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $virologiModel->errors());
    }

    if (!isset($virologi->id) || !is_numeric(($virologi->id))) {
      $virologi->id = $virologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Virologi.virologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $virologiModel = model($this->modelPrefix . 'VirologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($virologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Virologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
