<?php

namespace App\Modules\Profile\Instansi\Sejarah\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class SejarahController extends AdminController
{
  protected $sejarahFilter;
  protected $sejarahModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\Sejarah\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Sejarah\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->sejarahFilter = model($this->modelPrefix . 'SejarahFilter');
    $this->adminLink = (ADMIN_AREA . '/sejarah/');
  }

  /**
   * Display the "new sejarah" form.
   */
  public function create()
  {
    if (!auth()->user()->can('sejarah.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $sejarahModel = model($this->modelPrefix . 'SejarahModel');

    $sejarah = $sejarahModel->withDeleted()->find(1);
    if ($sejarah === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'sejarah'   => $sejarah,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a sejarah.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $sejarahId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('sejarah.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $sejarahModel = model($this->modelPrefix . 'SejarahModel');

    $sejarah = $sejarahId !== null
      ? $sejarahModel->find($sejarahId)
      : $sejarahModel->newSejarah();

    /** 
     * if there is a sejarah id (so we run an update operation)
     * but such sejarah is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($sejarah === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Sejarah.sejarah')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $sejarah->$key = $value;
    }

    /** attempt validate and save */

    $sejarah->title = lang('Sejarah.sejarahTitle');

    if ($sejarahModel->save($sejarah) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $sejarahModel->errors());
    }

    if (!isset($sejarah->id) || !is_numeric(($sejarah->id))) {
      $sejarah->id = $sejarahModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Sejarah.sejarah')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $sejarahModel = model($this->modelPrefix . 'SejarahModel');
    $validation = \Config\Services::validation();
    $validation->setRules($sejarahModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\Sejarah\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
