<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Informasi\Veteriner\FormIkm\Controllers'], static function ($routes) {
  //  Manage FormIkm
  $routes->get('formikm', 'FormIkmController::create', ['as' => 'formikm-new']);
  $routes->post('formikm/save', 'FormIkmController::save');
});
