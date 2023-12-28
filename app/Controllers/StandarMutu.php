<?php

namespace App\Controllers;


class StandarMutu extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Instansi\StandarMutu\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'StandarMutuModel');

    $data = $themodel->findAll();

    return $this->render('gallery', [
      'title' => 'STANDAR MUTU',
      'data' => $data
    ]);
  }
}
