<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Downloads\Controllers'], static function ($routes) {
  //  Manage Downloads
  $routes->match(['get', 'post'], 'downloads', 'DownloadsController::list', ['as' => 'downloads-list']);
  $routes->get('downloads/new', 'DownloadsController::create', ['as' => 'download-new']);
  $routes->post('downloads/save', 'DownloadsController::save');
  $routes->get('downloads/(:num)', 'DownloadsController::edit/$1', ['as' => 'download-edit']);
  $routes->get('downloads/(:num)/delete', 'DownloadsController::delete/$1', ['as' => 'download-delete']);
  $routes->post('downloads/delete-batch', 'DownloadsController::deleteBatch');
  $routes->post('downloads/validateField/(:any)', 'DownloadsController::validateField/$1');
});
