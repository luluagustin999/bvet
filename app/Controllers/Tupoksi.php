<?php

namespace App\Controllers;


class Tupoksi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Tupoksi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'TupoksiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'TUPOKSI',
      'content' => $data
    ]);
  }
}
