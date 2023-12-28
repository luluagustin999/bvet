<?php

namespace App\Modules\Informasi\Veteriner\FormIkm;

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
      'title'           => lang('FormIkm.formikmTitle'),
      'namedRoute'      => 'formikm-new',
      'fontAwesomeIcon' => 'fas fa-file',
      'permission'      => 'formikm.view',
    ]);
    $sidebar->menu('sidebar')->collection('informasiveterinerikm')->addItem($item);
  }
}
