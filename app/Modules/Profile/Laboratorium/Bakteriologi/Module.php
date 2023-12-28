<?php

namespace App\Modules\Profile\Laboratorium\Bakteriologi;

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
      'title'           => lang('Bakteriologi.bakteriologiTitle'),
      'namedRoute'      => 'bakteriologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'bakteriologi.view',
      'weight' => 8
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
