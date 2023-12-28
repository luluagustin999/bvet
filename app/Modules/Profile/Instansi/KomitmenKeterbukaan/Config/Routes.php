<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\KomitmenKeterbukaan\Controllers'], static function ($routes) {
  //  Manage KomitmenKeterbukaan
  $routes->get('komitmenketerbukaan', 'KomitmenKeterbukaanController::create', ['as' => 'komitmenketerbukaan-new']);
  $routes->post('komitmenketerbukaan/save', 'KomitmenKeterbukaanController::save');
});
