<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\LayananPpid\Controllers'], static function ($routes) {
  //  Manage LayananPpid
  $routes->match(['get', 'post'], 'layananppid', 'LayananPpidController::list', ['as' => 'layananppid-list']);
  $routes->get('layananppid/new', 'LayananPpidController::create', ['as' => 'layananppid-new']);
  $routes->post('layananppid/save', 'LayananPpidController::save');
  $routes->get('layananppid/(:num)', 'LayananPpidController::edit/$1', ['as' => 'layananppid-edit']);
  $routes->get('layananppid/(:num)/delete', 'LayananPpidController::delete/$1', ['as' => 'layananppid-delete']);
  $routes->post('layananppid/delete-batch', 'LayananPpidController::deleteBatch');
  $routes->post('layananppid/validateField/(:any)', 'LayananPpidController::validateField/$1');
});
