<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Aplikasi\Controllers'], static function ($routes) {
  //  Manage Aplikasi
  $routes->match(['get', 'post'], 'aplikasi', 'AplikasiController::list', ['as' => 'aplikasi-list']);
  $routes->get('aplikasi/new', 'AplikasiController::create', ['as' => 'aplikasi-new']);
  $routes->post('aplikasi/save', 'AplikasiController::save');
  $routes->get('aplikasi/(:num)', 'AplikasiController::edit/$1', ['as' => 'aplikasi-edit']);
  $routes->get('aplikasi/(:num)/delete', 'AplikasiController::delete/$1', ['as' => 'aplikasi-delete']);
  $routes->post('aplikasi/delete-batch', 'AplikasiController::deleteBatch');
  $routes->post('aplikasi/validateField/(:any)', 'AplikasiController::validateField/$1');
});
