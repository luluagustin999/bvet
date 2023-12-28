<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Kemavet\Controllers'], static function ($routes) {
  //  Manage Kemavet
  $routes->get('kemavet', 'KemavetController::create', ['as' => 'kemavet-new']);
  $routes->post('kemavet/save', 'KemavetController::save');
});
