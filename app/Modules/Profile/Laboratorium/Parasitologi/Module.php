<?php

namespace App\Modules\Profile\Laboratorium\Parasitologi;

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
      'title'           => lang('Parasitologi.parasitologiTitle'),
      'namedRoute'      => 'parasitologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'parasitologi.view',
      'weight' => 3
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
