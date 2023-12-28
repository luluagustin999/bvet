<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Bakteriologi\Controllers'], static function ($routes) {
  //  Manage Bakteriologi
  $routes->get('bakteriologi', 'BakteriologiController::create', ['as' => 'bakteriologi-new']);
  $routes->post('bakteriologi/save', 'BakteriologiController::save');
});
