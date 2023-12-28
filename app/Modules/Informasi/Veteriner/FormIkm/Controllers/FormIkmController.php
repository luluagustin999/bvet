<?php

namespace App\Modules\Informasi\Veteriner\FormIkm\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class FormIkmController extends AdminController
{
  protected $formikmFilter;
  protected $formikmModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\FormIkm\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\FormIkm\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->formikmFilter = model($this->modelPrefix . 'FormIkmFilter');
    $this->adminLink = (ADMIN_AREA . '/formikm/');
  }

  /**
   * Display the "new formikm" form.
   */
  public function create()
  {
    if (!auth()->user()->can('formikm.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $formikmModel = model($this->modelPrefix . 'FormIkmModel');

    $formikm = $formikmModel->withDeleted()->find(1);
    if ($formikm === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'formikm'   => $formikm,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a formikm.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $formikmId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('formikm.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $formikmModel = model($this->modelPrefix . 'FormIkmModel');

    $formikm = $formikmId !== null
      ? $formikmModel->find($formikmId)
      : $formikmModel->newFormIkm();

    /** 
     * if there is a formikm id (so we run an update operation)
     * but such formikm is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($formikm === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('FormIkm.formikm')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $formikm->$key = $value;
    }

    /** attempt validate and save */

    $formikm->title = lang('FormIkm.formikmTitle');

    if ($formikmModel->save($formikm) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $formikmModel->errors());
    }

    if (!isset($formikm->id) || !is_numeric(($formikm->id))) {
      $formikm->id = $formikmModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('FormIkm.formikm')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $formikmModel = model($this->modelPrefix . 'FormIkmModel');
    $validation = \Config\Services::validation();
    $validation->setRules($formikmModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Informasi\Veteriner\FormIkm\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
