<?php

namespace App\Modules\Profile\Laboratorium\Bioteknologi;

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
      'title'           => lang('Bioteknologi.bioteknologiTitle'),
      'namedRoute'      => 'bioteknologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'bioteknologi.view',
      'weight' => 5,
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
