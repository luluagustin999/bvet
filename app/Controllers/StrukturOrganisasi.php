<?php

namespace App\Controllers;


class StrukturOrganisasi extends BaseController
{
  protected $modelPrefix = 'App\Modules\Profile\SDM\StrukturOrganisasi\Models\\';
  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'StrukturOrganisasiModel');

    $data = $themodel->withDeleted()->find(1);

    return $this->render('pages', [
      'title' => 'STRUKTUR ORGANISASI',
      'content' => $data
    ]);
  }
}
