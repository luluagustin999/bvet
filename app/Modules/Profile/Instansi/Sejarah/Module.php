<?php

namespace App\Modules\Profile\Instansi\Sejarah;

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
      'title'           => lang('Sejarah.sejarahTitle'),
      'namedRoute'      => 'sejarah-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'sejarah.view',
      'weight' => 1
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
