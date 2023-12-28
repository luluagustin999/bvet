<?php

namespace App\Controllers;


class Berita extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Berita\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'BeritaModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'BERITA',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'BeritaModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'BERITA',
      'content' => $data[0],
    ]);
  }
}
