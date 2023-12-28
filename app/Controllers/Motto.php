<?php

namespace App\Controllers;


class Motto extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Motto\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'MottoModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'MOTTO',
      'content' => $data
    ]);
  }
}
