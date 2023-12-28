<?php

namespace App\Modules\Profile\Laboratorium\Parasitologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class ParasitologiController extends AdminController
{
  protected $parasitologiFilter;
  protected $parasitologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Parasitologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Parasitologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->parasitologiFilter = model($this->modelPrefix . 'ParasitologiFilter');
    $this->adminLink = (ADMIN_AREA . '/parasitologi/');
  }

  /**
   * Display the "new parasitologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('parasitologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $parasitologiModel = model($this->modelPrefix . 'ParasitologiModel');

    $parasitologi = $parasitologiModel->withDeleted()->find(1);
    if ($parasitologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'parasitologi'   => $parasitologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a parasitologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $parasitologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('parasitologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $parasitologiModel = model($this->modelPrefix . 'ParasitologiModel');

    $parasitologi = $parasitologiId !== null
      ? $parasitologiModel->find($parasitologiId)
      : $parasitologiModel->newParasitologi();

    /** 
     * if there is a parasitologi id (so we run an update operation)
     * but such parasitologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($parasitologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Parasitologi.parasitologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $parasitologi->$key = $value;
    }

    /** attempt validate and save */

    $parasitologi->title = lang('Parasitologi.parasitologiTitle');

    if ($parasitologiModel->save($parasitologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $parasitologiModel->errors());
    }

    if (!isset($parasitologi->id) || !is_numeric(($parasitologi->id))) {
      $parasitologi->id = $parasitologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Parasitologi.parasitologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $parasitologiModel = model($this->modelPrefix . 'ParasitologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($parasitologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Parasitologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
