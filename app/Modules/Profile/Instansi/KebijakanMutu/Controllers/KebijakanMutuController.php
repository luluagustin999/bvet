<?php

namespace App\Modules\Profile\Instansi\KebijakanMutu\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class KebijakanMutuController extends AdminController
{
  protected $kebijakanmutuFilter;
  protected $kebijakanmutuModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\KebijakanMutu\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KebijakanMutu\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->kebijakanmutuFilter = model($this->modelPrefix . 'KebijakanMutuFilter');
    $this->adminLink = (ADMIN_AREA . '/kebijakanmutu/');
  }

  /**
   * Display the "new kebijakanmutu" form.
   */
  public function create()
  {
    if (!auth()->user()->can('kebijakanmutu.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $kebijakanmutuModel = model($this->modelPrefix . 'KebijakanMutuModel');

    $kebijakanmutu = $kebijakanmutuModel->withDeleted()->find(1);
    if ($kebijakanmutu === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'kebijakanmutu'   => $kebijakanmutu,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a kebijakanmutu.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $kebijakanmutuId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('kebijakanmutu.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $kebijakanmutuModel = model($this->modelPrefix . 'KebijakanMutuModel');

    $kebijakanmutu = $kebijakanmutuId !== null
      ? $kebijakanmutuModel->find($kebijakanmutuId)
      : $kebijakanmutuModel->newKebijakanMutu();

    /** 
     * if there is a kebijakanmutu id (so we run an update operation)
     * but such kebijakanmutu is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($kebijakanmutu === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('KebijakanMutu.kebijakanmutu')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $kebijakanmutu->$key = $value;
    }

    /** attempt validate and save */

    $kebijakanmutu->title = lang('KebijakanMutu.kebijakanmutuTitle');

    if ($kebijakanmutuModel->save($kebijakanmutu) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $kebijakanmutuModel->errors());
    }

    if (!isset($kebijakanmutu->id) || !is_numeric(($kebijakanmutu->id))) {
      $kebijakanmutu->id = $kebijakanmutuModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('KebijakanMutu.kebijakanmutu')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $kebijakanmutuModel = model($this->modelPrefix . 'KebijakanMutuModel');
    $validation = \Config\Services::validation();
    $validation->setRules($kebijakanmutuModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\KebijakanMutu\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
