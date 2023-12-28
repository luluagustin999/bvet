<?php

namespace App\Modules\Informasi\Veteriner\AlurPersyaratan;

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
      'title'           => lang('AlurPersyaratan.alurpersyaratanTitle'),
      'namedRoute'      => 'alurpersyaratan-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'alurpersyaratan.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerpelayananpublik')->addItem($item);
  }
}
