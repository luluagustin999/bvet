<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\Motto\Controllers'], static function ($routes) {
  //  Manage Motto
  $routes->get('motto', 'MottoController::create', ['as' => 'motto-new']);
  $routes->post('motto/save', 'MottoController::save');
});
