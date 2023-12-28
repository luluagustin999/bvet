<?php

namespace App\Modules\Profile\Laboratorium\Virologi;

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
      'title'           => lang('Virologi.virologiTitle'),
      'namedRoute'      => 'virologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'virologi.view',
      'weight' => 2
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
