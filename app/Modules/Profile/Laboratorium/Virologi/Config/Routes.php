<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Virologi\Controllers'], static function ($routes) {
  //  Manage Virologi
  $routes->get('virologi', 'VirologiController::create', ['as' => 'virologi-new']);
  $routes->post('virologi/save', 'VirologiController::save');
});
