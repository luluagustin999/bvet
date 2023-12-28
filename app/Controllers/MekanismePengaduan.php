<?php

namespace App\Controllers;


class MekanismePengaduan extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\MekanismePengaduan\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'MekanismePengaduanModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'MEKANISME PENGADUAN',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'MekanismePengaduanModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'MEKANISME PENGADUAN',
      'content' => $data[0],
    ]);
  }
}
