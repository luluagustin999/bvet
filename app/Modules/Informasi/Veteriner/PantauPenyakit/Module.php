<?php

namespace App\Modules\Informasi\Veteriner\PantauPenyakit;

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
      'title'           => lang('PantauPenyakit.pantaupenyakitTitle'),
      'namedRoute'      => 'pantaupenyakit-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pantaupenyakit.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveteriner')->addItem($item);
  }
}
