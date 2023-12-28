<?php

namespace App\Modules\Kinerja;

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
      'title'           => lang('Kinerja.kinerjaTitle'),
      'namedRoute'      => 'kinerja-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'kinerja.view',
    ]);
    $sidebar->menu('sidebar')->collection('kinerja')->addItem($item);
  }
}
