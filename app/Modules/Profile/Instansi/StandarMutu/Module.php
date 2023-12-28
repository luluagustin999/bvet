<?php

namespace App\Modules\Profile\Instansi\StandarMutu;

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
      'title'           => lang('StandarMutu.standarmutuTitle'),
      'namedRoute'      => 'standarmutu-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'standarmutu.view',
      'weight' => 10
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
