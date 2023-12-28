<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\PustakaOnline\Controllers'], static function ($routes) {
  //  Manage PustakaOnline
  $routes->get('pustakaonline', 'PustakaOnlineController::create', ['as' => 'pustakaonline-new']);
  $routes->post('pustakaonline/save', 'PustakaOnlineController::save');
});
