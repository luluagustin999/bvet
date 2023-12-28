<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Pengumuman\Controllers'], static function ($routes) {
  //  Manage Pengumuman
  $routes->match(['get', 'post'], 'pengumuman', 'PengumumanController::list', ['as' => 'pengumuman-list']);
  $routes->get('pengumuman/new', 'PengumumanController::create', ['as' => 'pengumuman-new']);
  $routes->post('pengumuman/save', 'PengumumanController::save');
  $routes->get('pengumuman/(:num)', 'PengumumanController::edit/$1', ['as' => 'pengumuman-edit']);
  $routes->get('pengumuman/(:num)/delete', 'PengumumanController::delete/$1', ['as' => 'pengumuman-delete']);
  $routes->post('pengumuman/delete-batch', 'PengumumanController::deleteBatch');
  $routes->post('pengumuman/validateField/(:any)', 'PengumumanController::validateField/$1');
});
