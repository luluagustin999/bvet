<?php

namespace App\Controllers;


class Parasitologi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\Laboratorium\Parasitologi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'ParasitologiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'PARASITOLOGI',
      'content' => $data
    ]);
  }
}
