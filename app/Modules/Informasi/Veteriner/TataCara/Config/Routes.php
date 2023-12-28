<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\TataCara\Controllers'], static function ($routes) {
  //  Manage TataCara
  $routes->match(['get', 'post'], 'tatacara', 'TataCaraController::list', ['as' => 'tatacara-list']);
  $routes->get('tatacara/new', 'TataCaraController::create', ['as' => 'tatacara-new']);
  $routes->post('tatacara/save', 'TataCaraController::save');
  $routes->get('tatacara/(:num)', 'TataCaraController::edit/$1', ['as' => 'tatacara-edit']);
  $routes->get('tatacara/(:num)/delete', 'TataCaraController::delete/$1', ['as' => 'tatacara-delete']);
  $routes->post('tatacara/delete-batch', 'TataCaraController::deleteBatch');
  $routes->post('tatacara/validateField/(:any)', 'TataCaraController::validateField/$1');
});
