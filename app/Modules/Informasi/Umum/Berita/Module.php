<?php

namespace App\Modules\Informasi\Umum\Berita;

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
      'title'           => lang('Berita.beritaTitle'),
      'namedRoute'      => 'berita-list',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'berita.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasipublikumum')->addItem($item);
  }
}
