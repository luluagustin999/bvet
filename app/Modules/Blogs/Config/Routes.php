<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Blogs\Controllers'], static function ($routes) {
  //  Manage Blogs
  $routes->match(['get', 'post'], 'blogs', 'BlogsController::list', ['as' => 'blogs-list']);
  $routes->get('blogs/new', 'BlogsController::create', ['as' => 'blog-new']);
  $routes->post('blogs/save', 'BlogsController::save');
  $routes->get('blogs/(:num)', 'BlogsController::edit/$1', ['as' => 'blog-edit']);
  $routes->get('blogs/(:num)/delete', 'BlogsController::delete/$1', ['as' => 'blog-delete']);
  $routes->post('blogs/delete-batch', 'BlogsController::deleteBatch');
  $routes->post('blogs/validateField/(:any)', 'BlogsController::validateField/$1');
});
