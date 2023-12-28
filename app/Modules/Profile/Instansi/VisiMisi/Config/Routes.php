<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\VisiMisi\Controllers'], static function ($routes) {
  //  Manage VisiMisi
  $routes->get('visimisi', 'VisiMisiController::create', ['as' => 'visimisi-new']);
  $routes->post('visimisi/save', 'VisiMisiController::save');
});
