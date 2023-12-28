<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Sop\Controllers'], static function ($routes) {
  //  Manage Sop
  $routes->match(['get', 'post'], 'sop', 'SopController::list', ['as' => 'sop-list']);
  $routes->get('sop/new', 'SopController::create', ['as' => 'sop-new']);
  $routes->post('sop/save', 'SopController::save');
  $routes->get('sop/(:num)', 'SopController::edit/$1', ['as' => 'sop-edit']);
  $routes->get('sop/(:num)/delete', 'SopController::delete/$1', ['as' => 'sop-delete']);
  $routes->post('sop/delete-batch', 'SopController::deleteBatch');
  $routes->post('sop/validateField/(:any)', 'SopController::validateField/$1');
});
