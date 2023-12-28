<?php

namespace App\Modules\Profile\Instansi\AlurPelayanan;

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
      'title'           => 'Alur Pelayanan',
      'namedRoute'      => 'alurpelayanan-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'alurpelayanan.view',
      'weight' => 5
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
