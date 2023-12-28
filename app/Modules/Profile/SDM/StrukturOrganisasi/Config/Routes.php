<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\SDM\StrukturOrganisasi\Controllers'], static function ($routes) {
  //  Manage StrukturOrganisasi
  $routes->get('strukturorganisasi', 'StrukturOrganisasiController::create', ['as' => 'strukturorganisasi-new']);
  $routes->post('strukturorganisasi/save', 'StrukturOrganisasiController::save');
});
