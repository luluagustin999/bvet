<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Patologi\Controllers'], static function ($routes) {
  //  Manage Patologi
  $routes->get('patologi', 'PatologiController::create', ['as' => 'patologi-new']);
  $routes->post('patologi/save', 'PatologiController::save');
});
