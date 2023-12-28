<?php

namespace App\Modules\Profile\Laboratorium\Epidimiologi;

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
      'title'           => lang('Epidimiologi.epidimiologiTitle'),
      'namedRoute'      => 'epidimiologi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'epidimiologi.view',
      'weight' => 6
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
