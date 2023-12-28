<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\AlurPersyaratan\Controllers'], static function ($routes) {
  //  Manage AlurPersyaratan
  $routes->match(['get', 'post'], 'alurpersyaratan', 'AlurPersyaratanController::list', ['as' => 'alurpersyaratan-list']);
  $routes->get('alurpersyaratan/new', 'AlurPersyaratanController::create', ['as' => 'alurpersyaratan-new']);
  $routes->post('alurpersyaratan/save', 'AlurPersyaratanController::save');
  $routes->get('alurpersyaratan/(:num)', 'AlurPersyaratanController::edit/$1', ['as' => 'alurpersyaratan-edit']);
  $routes->get('alurpersyaratan/(:num)/delete', 'AlurPersyaratanController::delete/$1', ['as' => 'alurpersyaratan-delete']);
  $routes->post('alurpersyaratan/delete-batch', 'AlurPersyaratanController::deleteBatch');
  $routes->post('alurpersyaratan/validateField/(:any)', 'AlurPersyaratanController::validateField/$1');
});
