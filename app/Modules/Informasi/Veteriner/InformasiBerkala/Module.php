<?php

namespace App\Modules\Informasi\Veteriner\InformasiBerkala;

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
      'title'           => lang('InformasiBerkala.informasiberkalaTitle'),
      'namedRoute'      => 'informasiberkala-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'informasiberkala.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerpublik')->addItem($item);
  }
}
