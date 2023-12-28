<?php

namespace App\Controllers;


class InstalasiHewan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\InstalasiHewan\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'InstalasiHewanModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'INSTALASI HEWAN PERCOBAAN',
      'content' => $data
    ]);
  }
}
