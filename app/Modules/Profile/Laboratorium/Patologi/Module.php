<?php

namespace App\Modules\Profile\Laboratorium\Patologi;

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
      'title'           => lang('Patologi.patologiTitle'),
      'namedRoute'      => 'patologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'patologi.view',
      'weight' => 1
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
