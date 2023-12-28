<?php

namespace App\Modules\Profile\SDM\DataPegawai;

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
      'title'           => lang('DataPegawai.datapegawaiTitle'),
      'namedRoute'      => 'datapegawai-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'datapegawai.view',
      'weight' => 3
    ]);
    $sidebar->menu('sidebar')->collection('sdm')->addItem($item);
  }
}
