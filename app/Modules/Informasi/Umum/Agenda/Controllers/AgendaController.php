<?php

namespace App\Modules\Informasi\Umum\Agenda\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Bonfire\Core\AdminController;
use CodeIgniter\Files\File;

//use CodeIgniter\Database\Exceptions\DataException;

class AgendaController extends AdminController
{
  protected $agendaFilter;
  protected $agendaModel;
  protected $adminLink;
  protected $helpers = ['form'];

  protected $theme      = 'Admin';
  protected $viewPrefix = 'App\Modules\Informasi\Umum\Agenda\Views\\';
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Agenda\Models\\';


  public function initController(
    RequestInterface $request,
    ResponseInterface $response,
    LoggerInterface $logger
  ) {
    parent::initController($request, $response, $logger);
    /** user code below */
    $this->agendaFilter = model($this->modelPrefix . 'AgendaFilter');
    $this->adminLink = (ADMIN_AREA . '/agenda/');
  }

  public function list()
  {
    if (!auth()->user()->can('agenda.list')) {
      return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
    }

    $searchQuery = $this->request->getPost('search'); // Get the search query from the request

    // will need to replace next with 
    $this->agendaFilter->filter($this->request->getPost('filters'));

    $view = $this->request->is('post')
      ? $this->viewPrefix . '_table'
      : $this->viewPrefix . 'list';

    return $this->render($view, [
      'headers' => [
        'tanggal'         => 'Tanggal',
        'kegiatan'         => 'Nama Kegiatan',
        'lokasi'         => 'Lokasi',
        'created_at'    => 'Created At',
      ],
      'showSelectAll' => true,
      'agenda'         => $this->agendaFilter->paginate(setting('Site.perPage')),
      'pager'         => $this->agendaFilter->pager,
      'searchQuery' => $searchQuery
    ]);
  }


  /**
   * Display the "new agenda" form.
   */
  public function create()
  {
    if (!auth()->user()->can('agenda.create')) {
      return redirect()->to($this->adminLink)->with('error', lang('Bonfire.notAuthorized'));
    }

    // TODO: transfer this to templates / views and make automatic
    // $viewMeta = service('viewMeta');
    // $viewMeta->setTitle('Sukurti puslapį' . ' | ' . setting('Site.siteName'));


    return $this->render($this->viewPrefix . 'form', [
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Display the Edit form for a single agenda.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function edit(int $pageId)
  {
    if (!auth()->user()->can('users.edit')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $agendaModel = model($this->modelPrefix . 'AgendaModel');

    $agenda = $agendaModel->withDeleted()->find($pageId);
    if ($agenda === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Agenda.agenda')]));
    }


    return $this->render($this->viewPrefix . 'form', [
      'agenda'   => $agenda,
      'adminLink' => $this->adminLink,
    ]);
  }

  /**
   * Creates new or saves an edited a agenda.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   *
   * @throws ReflectionException
   */
  public function save()
  {
    $pageId = $this->request->getPost('id');
    //need this link to use in ->to instead of ->back 
    //(because it is messed up by htmx validation calls)
    $currentUrl = $this->adminLink . ($pageId ?: 'new');

    if (!auth()->user()->can('agenda.edit')) {
      return redirect()->to($currentUrl)->with('error', lang('Bonfire.notAuthorized'));
    }

    $agendaModel = model($this->modelPrefix . 'AgendaModel');

    $agenda = $pageId !== null
      ? $agendaModel->find($pageId)
      : $agendaModel->newPage();

    /** 
     * if there is a agenda id (so we run an update operation)
     * but such agenda is not in db:
     */
    /** @phpstan-ignore-next-line */
    if ($agenda === null) {
      return redirect()->to($currentUrl)->withInput()->with('error', lang('Bonfire.resourceNotFound', [lang('Agenda.agenda')]));
    }

    /** set the post values to the object */
    foreach ($this->request->getPost() as $key => $value) {
      $agenda->$key = $value;
    }

    /** attempt validate and save */

    if ($agendaModel->save($agenda) === false) {

      return redirect()->to($currentUrl)->withInput()->with('errors', $agendaModel->errors());
    }

    if (!isset($agenda->id) || !is_numeric(($agenda->id))) {
      $agenda->id = $agendaModel->getInsertID();
    }

    return redirect()->to(site_url($this->adminLink . $agenda->id))->with('message', lang('Bonfire.resourceSaved', [lang('Agenda.agenda')]));
  }

  /**
   * Delete the specified user.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete(int $pageId)
  {
    if (!auth()->user()->can('agenda.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $agendaModel = model($this->modelPrefix . 'AgendaModel');
    /** @var User|null $user */
    $agenda = $agendaModel->find($pageId);

    if ($agenda === null) {
      return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', [lang('Agenda.agenda')]));
    }

    if (!$agendaModel->delete($agenda->id)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourceDeleted', [lang('Agenda.agenda')]));
  }


  /** 
   * Deletes multiple agenda from the database.
   * Called via the checked() records in the table.
   */
  public function deleteBatch()
  {
    if (!auth()->user()->can('agenda.delete')) {
      return redirect()->back()->with('error', lang('Bonfire.notAuthorized'));
    }

    $ids = $this->request->getPost('selects');

    if (empty($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.resourcesNotSelected', [lang('Agenda.agenda')]));
    }
    $ids = array_keys($ids);

    $agendaModel = model($this->modelPrefix . 'AgendaModel');

    if (!$agendaModel->delete($ids)) {
      return redirect()->back()->with('error', lang('Bonfire.unknownError'));
    }

    return redirect()->back()->with('message', lang('Bonfire.resourcesDeleted', [lang('Agenda.agenda')]));
  }

  /**
   * Validation for any field
   */
  public function validateField(string $fieldName): string
  {
    $agendaModel = model($this->modelPrefix . 'AgendaModel');
    $validation = \Config\Services::validation();
    $validation->setRules($agendaModel->getValidationRules(['only' => [$fieldName]]));
    $validation->withRequest($this->request)->run();

    return $validation->getError($fieldName);
  }
}
