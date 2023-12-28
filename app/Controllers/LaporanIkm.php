<?php

namespace App\Controllers;


class LaporanIkm extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\LaporanIkm\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'LaporanIkmModel');


    $data = $themodel->findAll();


    $header = ['Deskripsi', 'Download'];

    $content = '';

    // Loop through the data and build the HTML string
    foreach ($data as $row) {
      $content .= "<tr>";
      $content .= "<td>" . esc($row->deskripsi) . "</td>"; // Replace 'column1' with your actual column name
      $content .= "<td>";
      $content .= "<a style='background: #7e589b;' href='" . base_url($row->file) . "' class='btn waves-effect waves-light btn-primary'>Download</a>";
      $content .= "</td>";
      $content .= "</tr>";
    }

    return $this->render('download', [
      'title' => 'LAPORAN IKM',
      'content' => $content,
      'header' => $header,
    ]);
  }
}
