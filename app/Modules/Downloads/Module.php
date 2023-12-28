<?php

namespace App\Modules\Downloads;

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
      'title'           => lang('Downloads.downloadTitle'),
      'namedRoute'      => 'downloads-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'downloads.view',
    ]);
  }
}
