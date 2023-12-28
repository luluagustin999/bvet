<?php

namespace App\Controllers;


class Patologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Patologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'PatologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'PATOLOGI',
      'content' => $data
    ]);
  }
}
