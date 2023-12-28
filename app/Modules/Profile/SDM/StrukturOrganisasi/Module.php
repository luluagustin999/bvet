<?php

namespace App\Modules\Profile\SDM\StrukturOrganisasi;

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
      'title'           => lang('StrukturOrganisasi.strukturorganisasiTitle'),
      'namedRoute'      => 'strukturorganisasi-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'strukturorganisasi.view',
      'weight' => 1
    ]);
    $sidebar->menu('sidebar')->collection('sdm')->addItem($item);
  }
}
