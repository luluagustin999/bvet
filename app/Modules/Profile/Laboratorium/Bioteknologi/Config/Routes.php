<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Bioteknologi\Controllers'], static function ($routes) {
  //  Manage Bioteknologi
  $routes->get('bioteknologi', 'BioteknologiController::create', ['as' => 'bioteknologi-new']);
  $routes->post('bioteknologi/save', 'BioteknologiController::save');
});
