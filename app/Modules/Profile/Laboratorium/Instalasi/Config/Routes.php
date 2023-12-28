<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Instalasi\Controllers'], static function ($routes) {
  //  Manage Instalasi
  $routes->get('instalasi', 'InstalasiController::create', ['as' => 'instalasi-new']);
  $routes->post('instalasi/save', 'InstalasiController::save');
});
