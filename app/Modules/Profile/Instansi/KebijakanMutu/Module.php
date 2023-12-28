<?php

namespace App\Modules\Profile\Instansi\KebijakanMutu;

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
      'title'           => lang('KebijakanMutu.kebijakanmutuTitle'),
      'namedRoute'      => 'kebijakanmutu-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'kebijakanmutu.view',
      'weight' => 8
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
