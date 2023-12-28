<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\InformasiSerta\Controllers'], static function ($routes) {
  //  Manage InformasiSerta
  $routes->match(['get', 'post'], 'informasiserta', 'InformasiSertaController::list', ['as' => 'informasiserta-list']);
  $routes->get('informasiserta/new', 'InformasiSertaController::create', ['as' => 'informasiserta-new']);
  $routes->post('informasiserta/save', 'InformasiSertaController::save');
  $routes->get('informasiserta/(:num)', 'InformasiSertaController::edit/$1', ['as' => 'informasiserta-edit']);
  $routes->get('informasiserta/(:num)/delete', 'InformasiSertaController::delete/$1', ['as' => 'informasiserta-delete']);
  $routes->post('informasiserta/delete-batch', 'InformasiSertaController::deleteBatch');
  $routes->post('informasiserta/validateField/(:any)', 'InformasiSertaController::validateField/$1');
});
