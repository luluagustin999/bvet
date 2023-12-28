<?php

namespace App\Modules\Profile\Instansi\Tupoksi;

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
      'title'           => lang('Tupoksi.tupoksiTitle'),
      'namedRoute'      => 'tupoksi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'tupoksi.view',
      'weight' => 4
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
