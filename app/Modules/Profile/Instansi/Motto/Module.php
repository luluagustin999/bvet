<?php

namespace App\Modules\Profile\Instansi\Motto;

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
      'title'           => lang('Motto.mottoTitle'),
      'namedRoute'      => 'motto-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'motto.view',
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
