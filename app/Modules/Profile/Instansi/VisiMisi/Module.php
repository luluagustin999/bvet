<?php

namespace App\Modules\Profile\Instansi\VisiMisi;

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
      'title'           => lang('VisiMisi.visimisiTitle'),
      'namedRoute'      => 'visimisi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'visimisi.view',
      'weight' => 2
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
