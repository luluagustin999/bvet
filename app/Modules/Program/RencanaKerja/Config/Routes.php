<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Program\RencanaKerja\Controllers'], static function ($routes) {
  //  Manage RencanaKerja
  $routes->match(['get', 'post'], 'rencanakerja', 'RencanaKerjaController::list', ['as' => 'rencanakerja-list']);
  $routes->get('rencanakerja/new', 'RencanaKerjaController::create', ['as' => 'rencanakerja-new']);
  $routes->post('rencanakerja/save', 'RencanaKerjaController::save');
  $routes->get('rencanakerja/(:num)', 'RencanaKerjaController::edit/$1', ['as' => 'rencanakerja-edit']);
  $routes->get('rencanakerja/(:num)/delete', 'RencanaKerjaController::delete/$1', ['as' => 'rencanakerja-delete']);
  $routes->post('rencanakerja/delete-batch', 'RencanaKerjaController::deleteBatch');
  $routes->post('rencanakerja/validateField/(:any)', 'RencanaKerjaController::validateField/$1');
});
