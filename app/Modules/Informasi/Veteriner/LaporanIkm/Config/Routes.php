<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\LaporanIkm\Controllers'], static function ($routes) {
  //  Manage LaporanIkm
  $routes->match(['get', 'post'], 'laporanikm', 'LaporanIkmController::list', ['as' => 'laporanikm-list']);
  $routes->get('laporanikm/new', 'LaporanIkmController::create', ['as' => 'laporanikm-new']);
  $routes->post('laporanikm/save', 'LaporanIkmController::save');
  $routes->get('laporanikm/(:num)', 'LaporanIkmController::edit/$1', ['as' => 'laporanikm-edit']);
  $routes->get('laporanikm/(:num)/delete', 'LaporanIkmController::delete/$1', ['as' => 'laporanikm-delete']);
  $routes->post('laporanikm/delete-batch', 'LaporanIkmController::deleteBatch');
  $routes->post('laporanikm/validateField/(:any)', 'LaporanIkmController::validateField/$1');
});
