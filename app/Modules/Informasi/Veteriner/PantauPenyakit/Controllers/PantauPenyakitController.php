<?php

namespace App\Modules\Informasi\Veteriner\PantauPenyakit\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PantauPenyakitController extends AdminController
{
  protected $pantaupenyakitFilter;
  protected $pantaupenyakitModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\PantauPenyakit\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\PantauPenyakit\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pantaupenyakitFilter = model($this->modelPrefix . 'PantauPenyakitFilter');
    $this->adminLink = (ADMIN_AREA . '/pantaupenyakit/');
  }

  /**
   * Display the "new pantaupenyakit" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pantaupenyakit.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $pantaupenyakitModel = model($this->modelPrefix . 'PantauPenyakitModel');

    $pantaupenyakit = $pantaupenyakitModel->withDeleted()->find(1);
    if ($pantaupenyakit === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'pantaupenyakit'   => $pantaupenyakit,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a pantaupenyakit.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pantaupenyakitId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('pantaupenyakit.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pantaupenyakitModel = model($this->modelPrefix . 'PantauPenyakitModel');

    $pantaupenyakit = $pantaupenyakitId !== null
      ? $pantaupenyakitModel->find($pantaupenyakitId)
      : $pantaupenyakitModel->newPantauPenyakit();

    /** 
     * if there is a pantaupenyakit id (so we run an update operation)
     * but such pantaupenyakit is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pantaupenyakit === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('PantauPenyakit.pantaupenyakit')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pantaupenyakit->$key = $value;
    }

    /** attempt validate and save */

    $pantaupenyakit->title = lang('PantauPenyakit.pantaupenyakitTitle');

    if ($pantaupenyakitModel->save($pantaupenyakit) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pantaupenyakitModel->errors());
    }

    if (!isset($pantaupenyakit->id) || !is_numeric(($pantaupenyakit->id))) {
      $pantaupenyakit->id = $pantaupenyakitModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('PantauPenyakit.pantaupenyakit')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pantaupenyakitModel = model($this->modelPrefix . 'PantauPenyakitModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pantaupenyakitModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Informasi\Veteriner\PantauPenyakit\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
