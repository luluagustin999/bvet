<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\SertifikatHasil\Controllers'], static function ($routes) {
  //  Manage SertifikatHasil
  $routes->get('sertifikathasil', 'SertifikatHasilController::create', ['as' => 'sertifikathasil-new']);
  $routes->post('sertifikathasil/save', 'SertifikatHasilController::save');
});
