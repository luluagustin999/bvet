<?php

namespace App\Modules\Informasi\Veteriner\MekanismePengaduan;

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
      'title'           => lang('MekanismePengaduan.mekanismepengaduanTitle'),
      'namedRoute'      => 'mekanismepengaduan-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'mekanismepengaduan.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerpelayananpublik')->addItem($item);
  }
}
