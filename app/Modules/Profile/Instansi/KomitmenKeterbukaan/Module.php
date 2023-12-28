<?php

namespace App\Modules\Profile\Instansi\KomitmenKeterbukaan;

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
      'title'           => lang('KomitmenKeterbukaan.komitmenketerbukaanTitle'),
      'namedRoute'      => 'komitmenketerbukaan-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'komitmenketerbukaan.view',
      'weight' => 9
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
