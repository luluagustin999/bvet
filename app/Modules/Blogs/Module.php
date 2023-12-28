<?php

namespace App\Modules\Blogs;

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
      'title'           => lang('Blogs.blogTitle'),
      'namedRoute'      => 'blogs-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'blogs.view',
    ]);
  }
}
