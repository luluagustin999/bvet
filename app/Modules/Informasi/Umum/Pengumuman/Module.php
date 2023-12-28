<?php

namespace App\Modules\Informasi\Umum\Pengumuman;

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
      'title'           => lang('Pengumuman.pengumumanTitle'),
      'namedRoute'      => 'pengumuman-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pengumuman.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublikumum')->addItem($item);
  }
}
