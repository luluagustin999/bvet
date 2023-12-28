<?php

namespace App\Controllers;


class VisiMisi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\VisiMisi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'VisiMisiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'VISI MISI',
      'content' => $data
    ]);
  }
}
