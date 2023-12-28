<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\StandarPelayanan\Controllers'], static function ($routes) {
  //  Manage StandarPelayanan
  $routes->match(['get', 'post'], 'standarpelayanan', 'StandarPelayananController::list', ['as' => 'standarpelayanan-list']);
  $routes->get('standarpelayanan/new', 'StandarPelayananController::create', ['as' => 'standarpelayanan-new']);
  $routes->post('standarpelayanan/save', 'StandarPelayananController::save');
  $routes->get('standarpelayanan/(:num)', 'StandarPelayananController::edit/$1', ['as' => 'standarpelayanan-edit']);
  $routes->get('standarpelayanan/(:num)/delete', 'StandarPelayananController::delete/$1', ['as' => 'standarpelayanan-delete']);
  $routes->post('standarpelayanan/delete-batch', 'StandarPelayananController::deleteBatch');
  $routes->post('standarpelayanan/validateField/(:any)', 'StandarPelayananController::validateField/$1');
});
