<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\KomitmenBersama\Controllers'], static function ($routes) {
  //  Manage KomitmenBersama
  $routes->get('komitmenbersama', 'KomitmenBersamaController::create', ['as' => 'komitmenbersama-new']);
  $routes->post('komitmenbersama/save', 'KomitmenBersamaController::save');
});
