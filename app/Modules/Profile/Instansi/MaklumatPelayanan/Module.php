<?php

namespace App\Modules\Profile\Instansi\MaklumatPelayanan;

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
      'title'           => lang('MaklumatPelayanan.maklumatpelayananTitle'),
      'namedRoute'      => 'maklumatpelayanan-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'maklumatpelayanan.view',
      'weight' => 6
    ]);
    $sidebar->menu('sidebar')->collection('instansi')->addItem($item);
  }
}
