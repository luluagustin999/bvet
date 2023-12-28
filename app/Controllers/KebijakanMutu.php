<?php

namespace App\Controllers;


class KebijakanMutu extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\KebijakanMutu\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'KebijakanMutuModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'KEBIJAKAN MUTU',
      'content' => $data
    ]);
  }
}
