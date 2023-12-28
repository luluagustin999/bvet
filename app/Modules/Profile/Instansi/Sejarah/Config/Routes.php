<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\Sejarah\Controllers'], static function ($routes) {
  //  Manage Sejarah
  $routes->get('sejarah', 'SejarahController::create', ['as' => 'sejarah-new']);
  $routes->post('sejarah/save', 'SejarahController::save');
});
