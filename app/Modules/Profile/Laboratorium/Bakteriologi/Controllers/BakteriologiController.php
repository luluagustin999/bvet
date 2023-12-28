<?php

namespace App\Modules\Profile\Laboratorium\Bakteriologi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class BakteriologiController extends AdminController
{
  protected $bakteriologiFilter;
  protected $bakteriologiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Bakteriologi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Bakteriologi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->bakteriologiFilter = model($this->modelPrefix . 'BakteriologiFilter');
    $this->adminLink = (ADMIN_AREA . '/bakteriologi/');
  }

  /**
   * Display the "new bakteriologi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('bakteriologi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $bakteriologiModel = model($this->modelPrefix . 'BakteriologiModel');

    $bakteriologi = $bakteriologiModel->withDeleted()->find(1);
    if ($bakteriologi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'bakteriologi'   => $bakteriologi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a bakteriologi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $bakteriologiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('bakteriologi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $bakteriologiModel = model($this->modelPrefix . 'BakteriologiModel');

    $bakteriologi = $bakteriologiId !== null
      ? $bakteriologiModel->find($bakteriologiId)
      : $bakteriologiModel->newBakteriologi();

    /** 
     * if there is a bakteriologi id (so we run an update operation)
     * but such bakteriologi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($bakteriologi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Bakteriologi.bakteriologi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $bakteriologi->$key = $value;
    }

    /** attempt validate and save */

    $bakteriologi->title = lang('Bakteriologi.bakteriologiTitle');

    if ($bakteriologiModel->save($bakteriologi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $bakteriologiModel->errors());
    }

    if (!isset($bakteriologi->id) || !is_numeric(($bakteriologi->id))) {
      $bakteriologi->id = $bakteriologiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Bakteriologi.bakteriologi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $bakteriologiModel = model($this->modelPrefix . 'BakteriologiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($bakteriologiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Bakteriologi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
