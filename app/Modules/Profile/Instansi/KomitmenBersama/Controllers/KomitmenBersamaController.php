<?php

namespace App\Modules\Profile\Instansi\KomitmenBersama\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class KomitmenBersamaController extends AdminController
{
  protected $komitmenbersamaFilter;
  protected $komitmenbersamaModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\KomitmenBersama\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KomitmenBersama\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->komitmenbersamaFilter = model($this->modelPrefix . 'KomitmenBersamaFilter');
    $this->adminLink = (ADMIN_AREA . '/komitmenbersama/');
  }

  /**
   * Display the "new komitmenbersama" form.
   */
  public function create()
  {
    if (!auth()->user()->can('komitmenbersama.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $komitmenbersamaModel = model($this->modelPrefix . 'KomitmenBersamaModel');

    $komitmenbersama = $komitmenbersamaModel->withDeleted()->find(1);
    if ($komitmenbersama === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'komitmenbersama'   => $komitmenbersama,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a komitmenbersama.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $komitmenbersamaId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('komitmenbersama.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $komitmenbersamaModel = model($this->modelPrefix . 'KomitmenBersamaModel');

    $komitmenbersama = $komitmenbersamaId !== null
      ? $komitmenbersamaModel->find($komitmenbersamaId)
      : $komitmenbersamaModel->newKomitmenBersama();

    /** 
     * if there is a komitmenbersama id (so we run an update operation)
     * but such komitmenbersama is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($komitmenbersama === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('KomitmenBersama.komitmenbersama')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $komitmenbersama->$key = $value;
    }

    /** attempt validate and save */

    $komitmenbersama->title = lang('KomitmenBersama.komitmenbersamaTitle');

    if ($komitmenbersamaModel->save($komitmenbersama) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $komitmenbersamaModel->errors());
    }

    if (!isset($komitmenbersama->id) || !is_numeric(($komitmenbersama->id))) {
      $komitmenbersama->id = $komitmenbersamaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('KomitmenBersama.komitmenbersama')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $komitmenbersamaModel = model($this->modelPrefix . 'KomitmenBersamaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($komitmenbersamaModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\KomitmenBersama\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
