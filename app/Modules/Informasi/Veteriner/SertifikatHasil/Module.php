<?php

namespace App\Modules\Informasi\Veteriner\SertifikatHasil;

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
      'title'           => lang('SertifikatHasil.sertifikathasilTitle'),
      'namedRoute'      => 'sertifikathasil-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'sertifikathasil.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveteriner')->addItem($item);
  }
}
