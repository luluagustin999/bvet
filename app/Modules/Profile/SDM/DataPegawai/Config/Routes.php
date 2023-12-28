<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\SDM\DataPegawai\Controllers'], static function ($routes) {
  //  Manage DataPegawai
  $routes->get('datapegawai', 'DataPegawaiController::create', ['as' => 'datapegawai-new']);
  $routes->post('datapegawai/save', 'DataPegawaiController::save');
});
