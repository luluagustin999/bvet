<?php

namespace App\Controllers;


class TataCara extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\TataCara\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'TataCaraModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'TATA CARA',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'TataCaraModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'TARIF PENGUJIAN',
      'content' => $data[0],
    ]);
  }
}
