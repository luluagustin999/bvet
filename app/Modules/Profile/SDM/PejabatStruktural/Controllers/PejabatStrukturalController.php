<?php

namespace App\Modules\Profile\SDM\PejabatStruktural\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PejabatStrukturalController extends AdminController
{
  protected $pejabatstrukturalFilter;
  protected $pejabatstrukturalModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Profile\SDM\PejabatStruktural\Views\\';
  protected $modelPrefix = 'App\Modules\Profile\SDM\PejabatStruktural\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pejabatstrukturalFilter = model($this->modelPrefix . 'PejabatStrukturalFilter');
    $this->adminLink = (ADMIN_AREA . '/pejabatstruktural/');
  }

  /**
   * Display the "new pejabatstruktural" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pejabatstruktural.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $pejabatstrukturalModel = model($this->modelPrefix . 'PejabatStrukturalModel');

    $pejabatstruktural = $pejabatstrukturalModel->withDeleted()->find(1);
    if ($pejabatstruktural === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'pejabatstruktural'   => $pejabatstruktural,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a pejabatstruktural.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pejabatstrukturalId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('pejabatstruktural.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pejabatstrukturalModel = model($this->modelPrefix . 'PejabatStrukturalModel');

    $pejabatstruktural = $pejabatstrukturalId !== null
      ? $pejabatstrukturalModel->find($pejabatstrukturalId)
      : $pejabatstrukturalModel->newPejabatStruktural();

    /** 
     * if there is a pejabatstruktural id (so we run an update operation)
     * but such pejabatstruktural is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pejabatstruktural === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('PejabatStruktural.pejabatstruktural')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pejabatstruktural->$key = $value;
    }

    /** attempt validate and save */

    $pejabatstruktural->title = lang('PejabatStruktural.pejabatstrukturalTitle');

    if ($pejabatstrukturalModel->save($pejabatstruktural) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pejabatstrukturalModel->errors());
    }

    if (!isset($pejabatstruktural->id) || !is_numeric(($pejabatstruktural->id))) {
      $pejabatstruktural->id = $pejabatstrukturalModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('PejabatStruktural.pejabatstruktural')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pejabatstrukturalModel = model($this->modelPrefix . 'PejabatStrukturalModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pejabatstrukturalModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Profile\SDM\PejabatStruktural\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
