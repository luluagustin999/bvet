<?php

namespace Config;

use Bonfire\Config\Bonfire as BonfireBonfire;

class Bonfire extends BonfireBonfire
{
  public $views = [
    'filter_list' => 'Bonfire\Views\_filter_list',
  ];

  /**
   * --------------------------------------------------------------------------
   * App Module locations
   * --------------------------------------------------------------------------
   *
   * Any folders that contain modules can be configured here.
   * When Bonfire boots up it will automatitcally load any modules in these
   * folders. The entries MUST be the namespace as the key, and the location
   * as the value.
   *
   *   'MyStuff' => 'app/Modules',
   *
   *  You may leave the array empty if you do not wish to use module discovery.
   */
  public $appModules = [
    'App\Modules' => APPPATH . 'Modules',

    // Profile instansi
    'App\Modules\Profile\Instansi' => APPPATH . 'Modules/Profile/Instansi',
    'App\Modules\Profile\SDM' => APPPATH . 'Modules/Profile/SDM',
    'App\Modules\Profile\Laboratorium' => APPPATH . 'Modules/Profile/Laboratorium',

    'App\Modules\Program' => APPPATH . 'Modules/Program',

    'App\Modules\Informasi' => APPPATH . 'Modules/Informasi',
    'App\Modules\Informasi\Umum' => APPPATH . 'Modules/Informasi/Umum',
    'App\Modules\Informasi\Veteriner' => APPPATH . 'Modules/Informasi/Veteriner',

  ];

  /**
   * --------------------------------------------------------------------------
   * Menu ordering
   * --------------------------------------------------------------------------
   *
   * $menuWeights property is an array of named routes as keys with weight
   * asigned to each named route as a value. If the module's named route
   * is not represented in this array, it's weight will default to 0 (highest
   * in the menu).
   *
   *   // Main content:
   *   'user-list'     => 1,
   *   'custom-list'    => 2,
   *
   *   // Settings submenu:
   *   'user-group-settings' => 0,
   *   // ... other items here
   *
   *   // Tools submenu:
   *   'recycler'      => 1,
   *   'sys-info'      => 2,
   *   'sys-logs'      => 3,
   *
   * It is used by MenuItem class to assign non-default weight to a menu.
   *
   * Menu Users and the menus belonging to custom modules can be arranged
   * this way, as well as the submenus of Tools and Settings. The placement
   * of menus Tools and Settings will not be affected by this setting.
   *
   */
  public $menuWeights = [];
}
