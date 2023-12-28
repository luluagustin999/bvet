<?php

namespace App\Modules\Informasi\Veteriner\InformasiSetiap;

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
      'title'           => lang('InformasiSetiap.informasisetiapTitle'),
      'namedRoute'      => 'informasisetiap-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'informasisetiap.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerpublik')->addItem($item);
  }
}
