<?php

namespace App\Controllers;


class KomitmenBersama extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KomitmenBersama\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'KomitmenBersamaModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'KOMTIMEN BERSAMA',
      'content' => $data
    ]);
  }
}
