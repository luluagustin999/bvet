<?php

namespace App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PengaduanMasyarakatController extends AdminController
{
  protected $pengaduanmasyarakatFilter;
  protected $pengaduanmasyarakatModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pengaduanmasyarakatFilter = model($this->modelPrefix . 'PengaduanMasyarakatFilter');
    $this->adminLink = (ADMIN_AREA . '/pengaduanmasyarakat/');
  }

  /**
   * Display the "new pengaduanmasyarakat" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pengaduanmasyarakat.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $pengaduanmasyarakatModel = model($this->modelPrefix . 'PengaduanMasyarakatModel');

    $pengaduanmasyarakat = $pengaduanmasyarakatModel->withDeleted()->find(1);
    if ($pengaduanmasyarakat === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'pengaduanmasyarakat'   => $pengaduanmasyarakat,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a pengaduanmasyarakat.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pengaduanmasyarakatId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('pengaduanmasyarakat.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pengaduanmasyarakatModel = model($this->modelPrefix . 'PengaduanMasyarakatModel');

    $pengaduanmasyarakat = $pengaduanmasyarakatId !== null
      ? $pengaduanmasyarakatModel->find($pengaduanmasyarakatId)
      : $pengaduanmasyarakatModel->newPengaduanMasyarakat();

    /** 
     * if there is a pengaduanmasyarakat id (so we run an update operation)
     * but such pengaduanmasyarakat is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pengaduanmasyarakat === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('PengaduanMasyarakat.pengaduanmasyarakat')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pengaduanmasyarakat->$key = $value;
    }

    /** attempt validate and save */

    $pengaduanmasyarakat->title = lang('PengaduanMasyarakat.pengaduanmasyarakatTitle');

    if ($pengaduanmasyarakatModel->save($pengaduanmasyarakat) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pengaduanmasyarakatModel->errors());
    }

    if (!isset($pengaduanmasyarakat->id) || !is_numeric(($pengaduanmasyarakat->id))) {
      $pengaduanmasyarakat->id = $pengaduanmasyarakatModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('PengaduanMasyarakat.pengaduanmasyarakat')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pengaduanmasyarakatModel = model($this->modelPrefix . 'PengaduanMasyarakatModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pengaduanmasyarakatModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
