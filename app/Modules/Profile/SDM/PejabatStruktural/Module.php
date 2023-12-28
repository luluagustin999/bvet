<?php

namespace App\Modules\Profile\SDM\PejabatStruktural;

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
      'title'           => lang('PejabatStruktural.pejabatstrukturalTitle'),
      'namedRoute'      => 'pejabatstruktural-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pejabatstruktural.view',
      'weight' => 2
    ]);
    $sidebar->menu('sidebar')->collection('sdm')->addItem($item);
  }
}
