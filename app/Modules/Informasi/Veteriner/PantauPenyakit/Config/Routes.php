<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\PantauPenyakit\Controllers'], static function ($routes) {
  //  Manage PantauPenyakit
  $routes->get('pantaupenyakit', 'PantauPenyakitController::create', ['as' => 'pantaupenyakit-new']);
  $routes->post('pantaupenyakit/save', 'PantauPenyakitController::save');
});
