<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Controllers'], static function ($routes) {
  //  Manage PengaduanMasyarakat
  $routes->get('pengaduanmasyarakat', 'PengaduanMasyarakatController::create', ['as' => 'pengaduanmasyarakat-new']);
  $routes->post('pengaduanmasyarakat/save', 'PengaduanMasyarakatController::save');
});
