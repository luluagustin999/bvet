<?php

namespace App\Modules\Program\Anggaran;

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
      'title'           => lang('Anggaran.anggaranTitle'),
      'namedRoute'      => 'anggaran-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'anggaran.view',
    ]);
    $sidebar->menu('sidebar')->collection('program')->addItem($item);
  }
}
