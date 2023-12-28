<?php

namespace App\Modules\Profile\Instansi\AlurPelayanan\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class AlurPelayananController extends AdminController
{
  protected $alurpelayananFilter;
  protected $alurpelayananModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\Instansi\AlurPelayanan\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\Instansi\AlurPelayanan\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->alurpelayananFilter = model($this->modelPrefix . 'AlurPelayananFilter');
    $this->adminLink = (ADMIN_AREA . '/alurpelayanan/');
  }

  /**
   * Display the "new alurpelayanan" form.
   */
  public function create()
  {
    if (!auth()->user()->can('alurpelayanan.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $alurpelayananModel = model($this->modelPrefix . 'AlurPelayananModel');

    $alurpelayanan = $alurpelayananModel->withDeleted()->find(1);
    if ($alurpelayanan === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'alurpelayanan'   => $alurpelayanan,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a alurpelayanan.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $alurpelayananId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('alurpelayanan.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $alurpelayananModel = model($this->modelPrefix . 'AlurPelayananModel');

    $alurpelayanan = $alurpelayananId !== null
      ? $alurpelayananModel->find($alurpelayananId)
      : $alurpelayananModel->newAlurPelayanan();

    /** 
     * if there is a alurpelayanan id (so we run an update operation)
     * but such alurpelayanan is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($alurpelayanan === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('AlurPelayanan.alurpelayanan')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $alurpelayanan->$key = $value;
    }

    /** attempt validate and save */

    $alurpelayanan->title = lang('AlurPelayanan.alurpelayananTitle');

    if ($alurpelayananModel->save($alurpelayanan) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $alurpelayananModel->errors());
    }

    if (!isset($alurpelayanan->id) || !is_numeric(($alurpelayanan->id))) {
      $alurpelayanan->id = $alurpelayananModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('AlurPelayanan.alurpelayanan')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $alurpelayananModel = model($this->modelPrefix . 'AlurPelayananModel');
    $validation = \Config\Services::validation();
    $validation->setRules($alurpelayananModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\Instansi\AlurPelayanan\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
