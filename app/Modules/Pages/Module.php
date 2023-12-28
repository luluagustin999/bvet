<?php

namespace App\Modules\Pages;

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
      'title'           => lang('Pages.pageTitle'),
      'namedRoute'      => 'page-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'pages.view',
    ]);
  }
}
