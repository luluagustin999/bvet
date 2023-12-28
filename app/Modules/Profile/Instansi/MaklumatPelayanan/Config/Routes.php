<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\MaklumatPelayanan\Controllers'], static function ($routes) {
  //  Manage MaklumatPelayanan
  $routes->get('maklumatpelayanan', 'MaklumatPelayananController::create', ['as' => 'maklumatpelayanan-new']);
  $routes->post('maklumatpelayanan/save', 'MaklumatPelayananController::save');
});
