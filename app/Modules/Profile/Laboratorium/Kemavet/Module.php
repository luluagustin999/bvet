<?php

namespace App\Modules\Profile\Laboratorium\Kemavet;

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
      'title'           => lang('Kemavet.kemavetTitle'),
      'namedRoute'      => 'kemavet-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'kemavet.view',
      'weight' => 4,
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
