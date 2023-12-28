<?php

namespace App\Controllers;


class TarifPengujian extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\TarifPengujian\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'TarifPengujianModel');

    $data = $themodel->findAll();

    return $this->render('blog-list', [
      'title' => 'TARIF PENGUJIAN',
      'data' => $data
    ]);
  }

  public function page(string $slug): string
  {
    $themodel = model($this->modelPrefix . 'TarifPengujianModel');

    $data = $themodel->where('slug', $slug)->find();

    return $this->render('pages', [
      'title' => 'TARIF PENGUJIAN',
      'content' => $data[0],
    ]);
  }
}
