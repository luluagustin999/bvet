<?php

namespace App\Modules\Informasi\LayananPpid;

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
      'title'           => lang('LayananPpid.layananppidTitle'),
      'namedRoute'      => 'layananppid-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'layananppid.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublik')->addItem($item);
  }
}
