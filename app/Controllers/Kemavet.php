<?php

namespace App\Controllers;


class Kemavet extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Kemavet\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'KemavetModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'KEMAVET',
      'content' => $data
    ]);
  }
}
