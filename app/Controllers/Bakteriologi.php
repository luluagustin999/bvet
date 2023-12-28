<?php

namespace App\Controllers;


class Bakteriologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Bakteriologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'BakteriologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'BAKTERIOLOGI',
      'content' => $data
    ]);
  }
}
