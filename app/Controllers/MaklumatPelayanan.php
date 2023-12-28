<?php

namespace App\Controllers;


class MaklumatPelayanan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\MaklumatPelayanan\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'MaklumatPelayananModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'MAKLUMAT PELAYANAN',
      'content' => $data
    ]);
  }
}
