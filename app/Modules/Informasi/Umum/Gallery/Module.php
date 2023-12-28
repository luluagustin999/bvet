<?php

namespace App\Modules\Informasi\Umum\Gallery;

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
      'title'           => lang('Gallery.galleryTitle'),
      'namedRoute'      => 'gallery-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'gallery.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublikumum')->addItem($item);
  }
}
