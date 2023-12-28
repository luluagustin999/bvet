<?php

namespace App\Modules\Profile\Instansi\Prestasi;

use Bonfire\Core\BaseModule;
use Bonfire\Menus\MenuItem;


class Module extends BaseModule
{
  /**
   * Setup our admin area needs.
   */
  public function initAdmin()
  {
    // Add to the Content menu
    $sidebar = service('menus');
    $item    = new MenuItem([
      'title'           => lang('Prestasi.prestasiTitle'),
      'namedRoute'      => 'prestasi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'prestasi.view',
      'weight' => 3
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
