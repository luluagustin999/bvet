<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Pages\Controllers'], static function ($routes) {
  //  Manage Pages
  $routes->get('pages', 'PagesController::create', ['as' => 'page-new']);
  $routes->post('pages/save', 'PagesController::save');
});
