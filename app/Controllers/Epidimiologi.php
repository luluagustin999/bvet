<?php

namespace App\Controllers;


class Epidimiologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Epidimiologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'EpidimiologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'EPIDIMIOLOGI',
      'content' => $data
    ]);
  }
}
