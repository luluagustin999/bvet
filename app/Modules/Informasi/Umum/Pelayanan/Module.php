<?php

namespace App\Modules\Informasi\Umum\Pelayanan;

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
      'title'           => lang('Pelayanan.pelayananTitle'),
      'namedRoute'      => 'pelayanan-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pelayanan.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublikumum')->addItem($item);
  }
}
