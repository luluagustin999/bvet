<?php

namespace App\Controllers;


class Prestasi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Prestasi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'PrestasiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'PRESTASI PENGHARGAAN',
      'content' => $data
    ]);
  }
}
