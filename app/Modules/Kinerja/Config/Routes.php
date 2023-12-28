<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Kinerja\Controllers'], static function ($routes) {
  //  Manage Kinerja
  $routes->match(['get', 'post'], 'kinerja', 'KinerjaController::list', ['as' => 'kinerja-list']);
  $routes->get('kinerja/new', 'KinerjaController::create', ['as' => 'kinerja-new']);
  $routes->post('kinerja/save', 'KinerjaController::save');
  $routes->get('kinerja/(:num)', 'KinerjaController::edit/$1', ['as' => 'kinerja-edit']);
  $routes->get('kinerja/(:num)/delete', 'KinerjaController::delete/$1', ['as' => 'kinerja-delete']);
  $routes->post('kinerja/delete-batch', 'KinerjaController::deleteBatch');
  $routes->post('kinerja/validateField/(:any)', 'KinerjaController::validateField/$1');
});
