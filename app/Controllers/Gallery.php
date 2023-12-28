<?php

namespace App\Controllers;


class Gallery extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Gallery\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'GalleryModel');

    $data = $themodel->findAll();

    return $this->render('gallery', [
      'title' => 'GALERI',
      'data' => $data
    ]);
  }
}
