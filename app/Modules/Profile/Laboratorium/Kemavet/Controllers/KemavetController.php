<?php

namespace App\Modules\Profile\Laboratorium\Kemavet\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class KemavetController extends AdminController
{
  protected $kemavetFilter;
  protected $kemavetModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Laboratorium\Kemavet\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Kemavet\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->kemavetFilter = model($this->modelPrefix . 'KemavetFilter');
    $this->adminLink = (ADMIN_AREA . '/kemavet/');
  }

  /**
   * Display the "new kemavet" form.
   */
  public function create()
  {
    if (!auth()->user()->can('kemavet.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $kemavetModel = model($this->modelPrefix . 'KemavetModel');

    $kemavet = $kemavetModel->withDeleted()->find(1);
    if ($kemavet === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'kemavet'   => $kemavet,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a kemavet.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $kemavetId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('kemavet.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $kemavetModel = model($this->modelPrefix . 'KemavetModel');

    $kemavet = $kemavetId !== null
      ? $kemavetModel->find($kemavetId)
      : $kemavetModel->newKemavet();

    /** 
     * if there is a kemavet id (so we run an update operation)
     * but such kemavet is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($kemavet === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Kemavet.kemavet')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $kemavet->$key = $value;
    }

    /** attempt validate and save */

    $kemavet->title = lang('Kemavet.kemavetTitle');

    if ($kemavetModel->save($kemavet) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $kemavetModel->errors());
    }

    if (!isset($kemavet->id) || !is_numeric(($kemavet->id))) {
      $kemavet->id = $kemavetModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('Kemavet.kemavet')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $kemavetModel = model($this->modelPrefix . 'KemavetModel');
    $validation = \Config\Services::validation();
    $validation->setRules($kemavetModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Laboratorium\Kemavet\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
