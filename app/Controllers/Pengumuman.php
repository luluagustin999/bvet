<?php

namespace App\Controllers;


class Pengumuman extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Pengumuman\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'PengumumanModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'PENGUMUMAN',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'PengumumanModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'PENGUMUMAN',
      'content' => $data[0],
    ]);
  }
}
