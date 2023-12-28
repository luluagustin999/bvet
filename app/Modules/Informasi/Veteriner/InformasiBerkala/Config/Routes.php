<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\InformasiBerkala\Controllers'], static function ($routes) {
  //  Manage InformasiBerkala
  $routes->match(['get', 'post'], 'informasiberkala', 'InformasiBerkalaController::list', ['as' => 'informasiberkala-list']);
  $routes->get('informasiberkala/new', 'InformasiBerkalaController::create', ['as' => 'informasiberkala-new']);
  $routes->post('informasiberkala/save', 'InformasiBerkalaController::save');
  $routes->get('informasiberkala/(:num)', 'InformasiBerkalaController::edit/$1', ['as' => 'informasiberkala-edit']);
  $routes->get('informasiberkala/(:num)/delete', 'InformasiBerkalaController::delete/$1', ['as' => 'informasiberkala-delete']);
  $routes->post('informasiberkala/delete-batch', 'InformasiBerkalaController::deleteBatch');
  $routes->post('informasiberkala/validateField/(:any)', 'InformasiBerkalaController::validateField/$1');
});
