<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Epidimiologi\Controllers'], static function ($routes) {
  //  Manage Epidimiologi
  $routes->get('epidimiologi', 'EpidimiologiController::create', ['as' => 'epidimiologi-new']);
  $routes->post('epidimiologi/save', 'EpidimiologiController::save');
});
