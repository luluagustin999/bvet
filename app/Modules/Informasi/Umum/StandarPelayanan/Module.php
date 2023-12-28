<?php

namespace App\Modules\Informasi\Umum\StandarPelayanan;

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
      'title'           => lang('StandarPelayanan.standarpelayananTitle'),
      'namedRoute'      => 'standarpelayanan-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'standarpelayanan.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublikumum')->addItem($item);
  }
}
