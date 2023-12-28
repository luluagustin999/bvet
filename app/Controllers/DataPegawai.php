<?php

namespace App\Controllers;


class DataPegawai extends BaseController
{
    protected $modelPrefix = 'App\Modules\Profile\SDM\DataPegawai\Models\\';
    public function index(): string
    {
        $themodel = model($this->modelPrefix . 'DataPegawaiModel');

        $data = $themodel->withDeleted()->find(1);

        return $this->render('pages', [
            'title' => 'DATA PEGAWAI',
            'content' => $data
        ]);
    }
}
