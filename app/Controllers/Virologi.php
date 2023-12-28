<?php

namespace App\Controllers;


class Virologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Virologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'VirologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'VIROLOGI',
      'content' => $data
    ]);
  }
}
