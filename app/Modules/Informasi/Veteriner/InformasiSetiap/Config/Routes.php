<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\InformasiSetiap\Controllers'], static function ($routes) {
  //  Manage InformasiSetiap
  $routes->match(['get', 'post'], 'informasisetiap', 'InformasiSetiapController::list', ['as' => 'informasisetiap-list']);
  $routes->get('informasisetiap/new', 'InformasiSetiapController::create', ['as' => 'informasisetiap-new']);
  $routes->post('informasisetiap/save', 'InformasiSetiapController::save');
  $routes->get('informasisetiap/(:num)', 'InformasiSetiapController::edit/$1', ['as' => 'informasisetiap-edit']);
  $routes->get('informasisetiap/(:num)/delete', 'InformasiSetiapController::delete/$1', ['as' => 'informasisetiap-delete']);
  $routes->post('informasisetiap/delete-batch', 'InformasiSetiapController::deleteBatch');
  $routes->post('informasisetiap/validateField/(:any)', 'InformasiSetiapController::validateField/$1');
});
