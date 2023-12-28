<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\TarifPengujian\Controllers'], static function ($routes) {
  //  Manage TarifPengujian
  $routes->match(['get', 'post'], 'tarifpengujian', 'TarifPengujianController::list', ['as' => 'tarifpengujian-list']);
  $routes->get('tarifpengujian/new', 'TarifPengujianController::create', ['as' => 'tarifpengujian-new']);
  $routes->post('tarifpengujian/save', 'TarifPengujianController::save');
  $routes->get('tarifpengujian/(:num)', 'TarifPengujianController::edit/$1', ['as' => 'tarifpengujian-edit']);
  $routes->get('tarifpengujian/(:num)/delete', 'TarifPengujianController::delete/$1', ['as' => 'tarifpengujian-delete']);
  $routes->post('tarifpengujian/delete-batch', 'TarifPengujianController::deleteBatch');
  $routes->post('tarifpengujian/validateField/(:any)', 'TarifPengujianController::validateField/$1');
});
