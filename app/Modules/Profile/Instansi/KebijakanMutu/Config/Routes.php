<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\KebijakanMutu\Controllers'], static function ($routes) {
  //  Manage KebijakanMutu
  $routes->get('kebijakanmutu', 'KebijakanMutuController::create', ['as' => 'kebijakanmutu-new']);
  $routes->post('kebijakanmutu/save', 'KebijakanMutuController::save');
});
