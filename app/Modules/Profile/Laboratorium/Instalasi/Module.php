<?php

namespace App\Modules\Profile\Laboratorium\Instalasi;

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
      'title'           => lang('Instalasi.instalasiTitle'),
      'namedRoute'      => 'instalasi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'instalasi.view',
    ]);
    $sidebar->menu('sidebar')->collection('laboratorium')->addItem($item);
  }
}
