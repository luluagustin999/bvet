<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\MekanismePengaduan\Controllers'], static function ($routes) {
  //  Manage MekanismePengaduan
  $routes->match(['get', 'post'], 'mekanismepengaduan', 'MekanismePengaduanController::list', ['as' => 'mekanismepengaduan-list']);
  $routes->get('mekanismepengaduan/new', 'MekanismePengaduanController::create', ['as' => 'mekanismepengaduan-new']);
  $routes->post('mekanismepengaduan/save', 'MekanismePengaduanController::save');
  $routes->get('mekanismepengaduan/(:num)', 'MekanismePengaduanController::edit/$1', ['as' => 'mekanismepengaduan-edit']);
  $routes->get('mekanismepengaduan/(:num)/delete', 'MekanismePengaduanController::delete/$1', ['as' => 'mekanismepengaduan-delete']);
  $routes->post('mekanismepengaduan/delete-batch', 'MekanismePengaduanController::deleteBatch');
  $routes->post('mekanismepengaduan/validateField/(:any)', 'MekanismePengaduanController::validateField/$1');
});
