<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Berita\Controllers'], static function ($routes) {
  //  Manage Berita
  $routes->match(['get', 'post'], 'berita', 'BeritaController::list', ['as' => 'berita-list']);
  $routes->get('berita/new', 'BeritaController::create', ['as' => 'berita-new']);
  $routes->post('berita/save', 'BeritaController::save');
  $routes->get('berita/(:num)', 'BeritaController::edit/$1', ['as' => 'berita-edit']);
  $routes->get('berita/(:num)/delete', 'BeritaController::delete/$1', ['as' => 'berita-delete']);
  $routes->post('berita/delete-batch', 'BeritaController::deleteBatch');
  $routes->post('berita/validateField/(:any)', 'BeritaController::validateField/$1');
});
