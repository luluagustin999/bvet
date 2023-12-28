<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Umum\ExternalLink\Controllers'], static function ($routes) {
  //  Manage ExternalLink
  $routes->match(['get', 'post'], 'externallink', 'ExternalLinkController::list', ['as' => 'externallink-list']);
  $routes->get('externallink/new', 'ExternalLinkController::create', ['as' => 'externallink-new']);
  $routes->post('externallink/save', 'ExternalLinkController::save');
  $routes->get('externallink/(:num)', 'ExternalLinkController::edit/$1', ['as' => 'externallink-edit']);
  $routes->get('externallink/(:num)/delete', 'ExternalLinkController::delete/$1', ['as' => 'externallink-delete']);
  $routes->post('externallink/delete-batch', 'ExternalLinkController::deleteBatch');
  $routes->post('externallink/validateField/(:any)', 'ExternalLinkController::validateField/$1');
});
