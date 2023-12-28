<?php

/**
 * @var CodeIgniter\Router\RouteCollection $routes
 */
$routes->group(ADMIN_AREA, ['namespace' => 'App\Modules\Profile\SDM\PejabatStruktural\Controllers'], static function ($routes) {
  //  Manage PejabatStruktural
  $routes->get('pejabatstruktural', 'PejabatStrukturalController::create', ['as' => 'pejabatstruktural-new']);
  $routes->post('pejabatstruktural/save', 'PejabatStrukturalController::save');
});
