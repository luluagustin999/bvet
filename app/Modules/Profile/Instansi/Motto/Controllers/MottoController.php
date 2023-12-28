<?php

namespace App\Modules\Profile\Instansi\Motto\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class MottoController extends AdminController
{
  protected $mottoFilter;
  protected $mottoModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\Motto\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Motto\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->mottoFilter = model($this->modelPrefix . 'MottoFilter');
    $this->adminLink = (ADMIN_AREA . '/motto/');
  }

  /**
   * Display the "new motto" form.
   */
  public function create()
  {
    if (!auth()->user()->can('motto.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $mottoModel = model($this->modelPrefix . 'MottoModel');

    $motto = $mottoModel->withDeleted()->find(1);
    if ($motto === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'motto'   => $motto,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a motto.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $mottoId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('motto.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $mottoModel = model($this->modelPrefix . 'MottoModel');

    $motto = $mottoId !== null
      ? $mottoModel->find($mottoId)
      : $mottoModel->newMotto();

    /** 
     * if there is a motto id (so we run an update operation)
     * but such motto is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($motto === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Motto.motto')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $motto->$key = $value;
    }

    /** attempt validate and save */

    $motto->title = lang('Motto.mottoTitle');

    if ($mottoModel->save($motto) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $mottoModel->errors());
    }

    if (!isset($motto->id) || !is_numeric(($motto->id))) {
      $motto->id = $mottoModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Motto.motto')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $mottoModel = model($this->modelPrefix . 'MottoModel');
    $validation = \Config\Services::validation();
    $validation->setRules($mottoModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\Motto\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
