<?php

namespace App\Controllers;


class Pelayanan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Pelayanan\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'PelayananModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'PELAYANAN PKL/MAGANG/BIMBINGAN TEKNIS',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'PelayananModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'PELAYANAN PKL/MAGANG/BIMBINGAN TEKNIS',
      'content' => $data[0],
    ]);
  }
}
