<?php

namespace App\Controllers;


class PejabatStruktural extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\SDM\PejabatStruktural\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'PejabatStrukturalModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'PEJABAT STRUKTURAL',
      'content' => $data
    ]);
  }
}
