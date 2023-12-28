<?php

namespace App\Controllers;


class AlurPelayanan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\AlurPelayanan\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'AlurPelayananModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'ALUR PELAYANAN',
      'content' => $data
    ]);
  }
}
