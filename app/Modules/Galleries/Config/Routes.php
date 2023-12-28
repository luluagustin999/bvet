<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Galleries\Controllers'], static function ($routes) {
  //  Manage Galleries
  $routes->match(['get', 'post'], 'galleries', 'GalleriesController::list', ['as' => 'galleries-list']);
  $routes->get('galleries/new', 'GalleriesController::create', ['as' => 'gallery-new']);
  $routes->post('galleries/save', 'GalleriesController::save');
  $routes->get('galleries/(:num)', 'GalleriesController::edit/$1', ['as' => 'gallery-edit']);
  $routes->get('galleries/(:num)/delete', 'GalleriesController::delete/$1', ['as' => 'gallery-delete']);
  $routes->post('galleries/delete-batch', 'GalleriesController::deleteBatch');
  $routes->post('galleries/validateField/(:any)', 'GalleriesController::validateField/$1');
  $routes->get('galleries/types', 'GalleriesController::types');
});
