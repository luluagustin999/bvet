<?php

namespace App\Modules\Informasi\Veteriner\TarifPengujian;

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
      'title'           => lang('TarifPengujian.tarifpengujianTitle'),
      'namedRoute'      => 'tarifpengujian-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'tarifpengujian.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveteriner')->addItem($item);
  }
}
