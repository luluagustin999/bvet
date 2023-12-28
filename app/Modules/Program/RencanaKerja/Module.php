<?php

namespace App\Modules\Program\RencanaKerja;

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
      'title'           => lang('RencanaKerja.rencanakerjaTitle'),
      'namedRoute'      => 'rencanakerja-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'rencanakerja.view',
    ]);
    $sidebar->menu('sidebar')->collection('program')->addItem($item);
  }
}
