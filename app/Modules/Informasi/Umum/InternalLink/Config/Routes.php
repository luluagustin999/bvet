<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\InternalLink\Controllers'], static function ($routes) {
  //  Manage InternalLink
  $routes->match(['get', 'post'], 'internallink', 'InternalLinkController::list', ['as' => 'internallink-list']);
  $routes->get('internallink/new', 'InternalLinkController::create', ['as' => 'internallink-new']);
  $routes->post('internallink/save', 'InternalLinkController::save');
  $routes->get('internallink/(:num)', 'InternalLinkController::edit/$1', ['as' => 'internallink-edit']);
  $routes->get('internallink/(:num)/delete', 'InternalLinkController::delete/$1', ['as' => 'internallink-delete']);
  $routes->post('internallink/delete-batch', 'InternalLinkController::deleteBatch');
  $routes->post('internallink/validateField/(:any)', 'InternalLinkController::validateField/$1');
});
