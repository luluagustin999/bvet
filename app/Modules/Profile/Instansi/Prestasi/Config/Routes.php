<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\Prestasi\Controllers'], static function ($routes) {
  //  Manage Prestasi
  $routes->get('prestasi', 'PrestasiController::create', ['as' => 'prestasi-new']);
  $routes->post('prestasi/save', 'PrestasiController::save');
});
