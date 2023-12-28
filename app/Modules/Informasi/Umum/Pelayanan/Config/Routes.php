<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Pelayanan\Controllers'], static function ($routes) {
  //  Manage Pelayanan
  $routes->match(['get', 'post'], 'pelayanan', 'PelayananController::list', ['as' => 'pelayanan-list']);
  $routes->get('pelayanan/new', 'PelayananController::create', ['as' => 'pelayanan-new']);
  $routes->post('pelayanan/save', 'PelayananController::save');
  $routes->get('pelayanan/(:num)', 'PelayananController::edit/$1', ['as' => 'pelayanan-edit']);
  $routes->get('pelayanan/(:num)/delete', 'PelayananController::delete/$1', ['as' => 'pelayanan-delete']);
  $routes->post('pelayanan/delete-batch', 'PelayananController::deleteBatch');
  $routes->post('pelayanan/validateField/(:any)', 'PelayananController::validateField/$1');
});
