<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\Gallery\Controllers'], static function ($routes) {
  //  Manage Gallery
  $routes->match(['get', 'post'], 'gallery', 'GalleryController::list', ['as' => 'gallery-list']);
  $routes->get('gallery/new', 'GalleryController::create', ['as' => 'gallery-new']);
  $routes->post('gallery/save', 'GalleryController::save');
  $routes->get('gallery/(:num)', 'GalleryController::edit/$1', ['as' => 'gallery-edit']);
  $routes->get('gallery/(:num)/delete', 'GalleryController::delete/$1', ['as' => 'gallery-delete']);
  $routes->post('gallery/delete-batch', 'GalleryController::deleteBatch');
  $routes->post('gallery/validateField/(:any)', 'GalleryController::validateField/$1');
  $routes->get('gallery/types', 'GalleryController::types');
});
