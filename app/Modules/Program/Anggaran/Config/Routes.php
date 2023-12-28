<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Program\Anggaran\Controllers'], static function ($routes) {
  //  Manage Anggaran
  $routes->match(['get', 'post'], 'anggaran', 'AnggaranController::list', ['as' => 'anggaran-list']);
  $routes->get('anggaran/new', 'AnggaranController::create', ['as' => 'anggaran-new']);
  $routes->post('anggaran/save', 'AnggaranController::save');
  $routes->get('anggaran/(:num)', 'AnggaranController::edit/$1', ['as' => 'anggaran-edit']);
  $routes->get('anggaran/(:num)/delete', 'AnggaranController::delete/$1', ['as' => 'anggaran-delete']);
  $routes->post('anggaran/delete-batch', 'AnggaranController::deleteBatch');
  $routes->post('anggaran/validateField/(:any)', 'AnggaranController::validateField/$1');
});
