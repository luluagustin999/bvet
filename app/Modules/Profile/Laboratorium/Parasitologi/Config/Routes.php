<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Laboratorium\Parasitologi\Controllers'], static function ($routes) {
  //  Manage Parasitologi
  $routes->get('parasitologi', 'ParasitologiController::create', ['as' => 'parasitologi-new']);
  $routes->post('parasitologi/save', 'ParasitologiController::save');
});
