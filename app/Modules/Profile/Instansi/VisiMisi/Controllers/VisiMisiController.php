<?php

namespace App\Modules\Profile\Instansi\VisiMisi\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class VisiMisiController extends AdminController
{
  protected $visimisiFilter;
  protected $visimisiModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\VisiMisi\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\VisiMisi\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->visimisiFilter = model($this->modelPrefix . 'VisiMisiFilter');
    $this->adminLink = (ADMIN_AREA . '/visimisi/');
  }

  /**
   * Display the "new visimisi" form.
   */
  public function create()
  {
    if (!auth()->user()->can('visimisi.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $visimisiModel = model($this->modelPrefix . 'VisiMisiModel');

    $visimisi = $visimisiModel->withDeleted()->find(1);
    if ($visimisi === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'visimisi'   => $visimisi,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a visimisi.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $visimisiId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('visimisi.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $visimisiModel = model($this->modelPrefix . 'VisiMisiModel');

    $visimisi = $visimisiId !== null
      ? $visimisiModel->find($visimisiId)
      : $visimisiModel->newVisiMisi();

    /** 
     * if there is a visimisi id (so we run an update operation)
     * but such visimisi is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($visimisi === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('VisiMisi.visimisi')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $visimisi->$key = $value;
    }

    /** attempt validate and save */

    $visimisi->title = lang('VisiMisi.visimisiTitle');

    if ($visimisiModel->save($visimisi) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $visimisiModel->errors());
    }

    if (!isset($visimisi->id) || !is_numeric(($visimisi->id))) {
      $visimisi->id = $visimisiModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('VisiMisi.visimisi')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $visimisiModel = model($this->modelPrefix . 'VisiMisiModel');
    $validation = \Config\Services::validation();
    $validation->setRules($visimisiModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\VisiMisi\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
