<?php

namespace App\Controllers;


class KomitmenKeterbukan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KomitmenKeterbukaan\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'KomitmenKeterbukaanModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'KOMITMEN KETERBUKAAN',
      'content' => $data
    ]);
  }
}
