<?php

namespace App\Modules\Informasi\Veteriner\PengaduanMasyarakat;

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
      'title'           => lang('PengaduanMasyarakat.pengaduanmasyarakatTitle'),
      'namedRoute'      => 'pengaduanmasyarakat-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pengaduanmasyarakat.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveteriner')->addItem($item);
  }
}
