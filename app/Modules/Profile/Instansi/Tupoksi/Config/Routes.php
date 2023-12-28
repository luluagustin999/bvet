<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\Tupoksi\Controllers'], static function ($routes) {
  //  Manage Tupoksi
  $routes->get('tupoksi', 'TupoksiController::create', ['as' => 'tupoksi-new']);
  $routes->post('tupoksi/save', 'TupoksiController::save');
});
