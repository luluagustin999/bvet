<?php

namespace App\Modules\Profile\Instansi\KomitmenKeterbukaan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class KomitmenKeterbukaanController extends AdminController
{
  protected $komitmenketerbukaanFilter;
  protected $komitmenketerbukaanModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\KomitmenKeterbukaan\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KomitmenKeterbukaan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->komitmenketerbukaanFilter = model($this->modelPrefix . 'KomitmenKeterbukaanFilter');
    $this->adminLink = (ADMIN_AREA . '/komitmenketerbukaan/');
  }

  /**
   * Display the "new komitmenketerbukaan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('komitmenketerbukaan.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $komitmenketerbukaanModel = model($this->modelPrefix . 'KomitmenKeterbukaanModel');

    $komitmenketerbukaan = $komitmenketerbukaanModel->withDeleted()->find(1);
    if ($komitmenketerbukaan === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'komitmenketerbukaan'   => $komitmenketerbukaan,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a komitmenketerbukaan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $komitmenketerbukaanId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('komitmenketerbukaan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $komitmenketerbukaanModel = model($this->modelPrefix . 'KomitmenKeterbukaanModel');

    $komitmenketerbukaan = $komitmenketerbukaanId !== null
      ? $komitmenketerbukaanModel->find($komitmenketerbukaanId)
      : $komitmenketerbukaanModel->newKomitmenKeterbukaan();

    /** 
     * if there is a komitmenketerbukaan id (so we run an update operation)
     * but such komitmenketerbukaan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($komitmenketerbukaan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('KomitmenKeterbukaan.komitmenketerbukaan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $komitmenketerbukaan->$key = $value;
    }

    /** attempt validate and save */

    $komitmenketerbukaan->title = lang('KomitmenKeterbukaan.komitmenketerbukaanTitle');

    if ($komitmenketerbukaanModel->save($komitmenketerbukaan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $komitmenketerbukaanModel->errors());
    }

    if (!isset($komitmenketerbukaan->id) || !is_numeric(($komitmenketerbukaan->id))) {
      $komitmenketerbukaan->id = $komitmenketerbukaanModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('KomitmenKeterbukaan.komitmenketerbukaan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $komitmenketerbukaanModel = model($this->modelPrefix . 'KomitmenKeterbukaanModel');
    $validation = \Config\Services::validation();
    $validation->setRules($komitmenketerbukaanModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\KomitmenKeterbukaan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
