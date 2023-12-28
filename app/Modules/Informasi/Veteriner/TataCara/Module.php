<?php

namespace App\Modules\Informasi\Veteriner\TataCara;

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
      'title'           => lang('TataCara.tatacaraTitle'),
      'namedRoute'      => 'tatacara-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'tatacara.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerpelayananpublik')->addItem($item);
  }
}
