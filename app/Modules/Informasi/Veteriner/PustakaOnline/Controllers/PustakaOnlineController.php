<?php

namespace App\Modules\Informasi\Veteriner\PustakaOnline\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class PustakaOnlineController extends AdminController
{
  protected $pustakaonlineFilter;
  protected $pustakaonlineModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Veteriner\PustakaOnline\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\PustakaOnline\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->pustakaonlineFilter = model($this->modelPrefix . 'PustakaOnlineFilter');
    $this->adminLink = (ADMIN_AREA . '/pustakaonline/');
  }

  /**
   * Display the "new pustakaonline" form.
   */
  public function create()
  {
    if (!auth()->user()->can('pustakaonline.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    $this->getTinyMCE();

    $pustakaonlineModel = model($this->modelPrefix . 'PustakaOnlineModel');

    $pustakaonline = $pustakaonlineModel->withDeleted()->find(1);
    if ($pustakaonline === null) {
      return $this->render($this->viewPrefix . 'form', [
        'adminLink' => $this->adminLink,
      ]);
    }

    return $this->render($this->viewPrefix . 'form', [
      'pustakaonline'   => $pustakaonline,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a pustakaonline.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pustakaonlineId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink;

    if (!auth()->user()->can('pustakaonline.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $pustakaonlineModel = model($this->modelPrefix . 'PustakaOnlineModel');

    $pustakaonline = $pustakaonlineId !== null
      ? $pustakaonlineModel->find($pustakaonlineId)
      : $pustakaonlineModel->newPustakaOnline();

    /** 
     * if there is a pustakaonline id (so we run an update operation)
     * but such pustakaonline is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($pustakaonline === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('PustakaOnline.pustakaonline')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $pustakaonline->$key = $value;
    }

    /** attempt validate and save */

    $pustakaonline->title = lang('PustakaOnline.pustakaonlineTitle');

    if ($pustakaonlineModel->save($pustakaonline) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $pustakaonlineModel->errors());
    }

    if (!isset($pustakaonline->id) || !is_numeric(($pustakaonline->id))) {
      $pustakaonline->id = $pustakaonlineModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink))->with('message', lang('Bonfire.resourceSaved', [lang('PustakaOnline.pustakaonline')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $pustakaonlineModel = model($this->modelPrefix . 'PustakaOnlineModel');
    $validation = \Config\Services::validation();
    $validation->setRules($pustakaonlineModel->getValidationRules(['only' => [$fieldName]]));
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
    $script = view('\App\Modules\Informasi\Veteriner\PustakaOnline\Views\_tinymce', [
      'locale' => $this->request->getLocale(),
      'url' => $this->adminLink . 'validateField/content',
    ]);
    $viewMeta->addRawScript($script);
  }
}
