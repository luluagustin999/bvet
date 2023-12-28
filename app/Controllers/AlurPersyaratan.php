<?php

namespace App\Controllers;


class AlurPersyaratan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\AlurPersyaratan\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'AlurPersyaratanModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'ALUR PERSYARATAN',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'AlurPersyaratanModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'ALUR PERSYARATAN',
      'content' => $data[0],
    ]);
  }
}
