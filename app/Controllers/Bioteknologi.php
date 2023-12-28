<?php

namespace App\Controllers;


class Bioteknologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Bioteknologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'BioteknologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'BIOTEKNOLOGI',
      'content' => $data
    ]);
  }
}
