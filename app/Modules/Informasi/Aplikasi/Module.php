<?php

namespace App\Modules\Informasi\Aplikasi;

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
      'title'           => lang('Aplikasi.aplikasiTitle'),
      'namedRoute'      => 'aplikasi-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'aplikasi.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublik')->addItem($item);
  }
}
