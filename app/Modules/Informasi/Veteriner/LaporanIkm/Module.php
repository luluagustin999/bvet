<?php

namespace App\Modules\Informasi\Veteriner\LaporanIkm;

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
      'title'           => lang('LaporanIkm.laporanikmTitle'),
      'namedRoute'      => 'laporanikm-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'laporanikm.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerikm')->addItem($item);
  }
}
