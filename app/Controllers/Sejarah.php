<?php

namespace App\Controllers;


class Sejarah extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\Sejarah\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'SejarahModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'SEJARAH',
      'content' => $data
    ]);
  }
}
