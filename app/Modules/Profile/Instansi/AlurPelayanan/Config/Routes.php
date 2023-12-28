<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\AlurPelayanan\Controllers'], static function ($routes) {
  //  Manage AlurPelayanan
  $routes->get('alurpelayanan', 'AlurPelayananController::create', ['as' => 'alurpelayanan-new']);
  $routes->post('alurpelayanan/save', 'AlurPelayananController::save');
});
