<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\Instansi\StandarMutu\Controllers'], static function ($routes) {
  //  Manage StandarMutu
  $routes->match(['get', 'post'], 'standarmutu', 'StandarMutuController::list', ['as' => 'standarmutu-list']);
  $routes->get('standarmutu/new', 'StandarMutuController::create', ['as' => 'standarmutu-new']);
  $routes->post('standarmutu/save', 'StandarMutuController::save');
  $routes->get('standarmutu/(:num)', 'StandarMutuController::edit/$1', ['as' => 'standarmutu-edit']);
  $routes->get('standarmutu/(:num)/delete', 'StandarMutuController::delete/$1', ['as' => 'standarmutu-delete']);
  $routes->post('standarmutu/delete-batch', 'StandarMutuController::deleteBatch');
  $routes->post('standarmutu/validateField/(:any)', 'StandarMutuController::validateField/$1');
  $routes->get('standarmutu/types', 'StandarMutuController::types');
});
