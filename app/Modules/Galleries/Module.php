<?php

namespace App\Modules\Galleries;

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
      'title'           => lang('Galleries.galleryTitle'),
      'namedRoute'      => 'galleries-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'galleries.view',
    ]);
  }
}
