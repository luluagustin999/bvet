<?php

namespace App\Modules\Profile\Instansi\KomitmenBersama;

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
      'title'           => lang('KomitmenBersama.komitmenbersamaTitle'),
      'namedRoute'      => 'komitmenbersama-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'komitmenbersama.view',
      'weight' => 7
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
