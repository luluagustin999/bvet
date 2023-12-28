<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Agenda\Controllers'], static function ($routes) {
  //  Manage Agenda
  $routes->match(['get', 'post'], 'agenda', 'AgendaController::list', ['as' => 'agenda-list']);
  $routes->get('agenda/new', 'AgendaController::create', ['as' => 'agenda-new']);
  $routes->post('agenda/save', 'AgendaController::save');
  $routes->get('agenda/(:num)', 'AgendaController::edit/$1', ['as' => 'agenda-edit']);
  $routes->get('agenda/(:num)/delete', 'AgendaController::delete/$1', ['as' => 'agenda-delete']);
  $routes->post('agenda/delete-batch', 'AgendaController::deleteBatch');
  $routes->post('agenda/validateField/(:any)', 'AgendaController::validateField/$1');
});
