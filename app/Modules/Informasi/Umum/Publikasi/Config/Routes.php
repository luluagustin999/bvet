<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Publikasi\Controllers'], static function ($routes) {
  //  Manage Publikasi
  $routes->match(['get', 'post'], 'publikasi', 'PublikasiController::list', ['as' => 'publikasi-list']);
  $routes->get('publikasi/new', 'PublikasiController::create', ['as' => 'publikasi-new']);
  $routes->post('publikasi/save', 'PublikasiController::save');
  $routes->get('publikasi/(:num)', 'PublikasiController::edit/$1', ['as' => 'publikasi-edit']);
  $routes->get('publikasi/(:num)/delete', 'PublikasiController::delete/$1', ['as' => 'publikasi-delete']);
  $routes->post('publikasi/delete-batch', 'PublikasiController::deleteBatch');
  $routes->post('publikasi/validateField/(:any)', 'PublikasiController::validateField/$1');
});
