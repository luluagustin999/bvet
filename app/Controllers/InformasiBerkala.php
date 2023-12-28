<?php

namespace App\Controllers;


class InformasiBerkala extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiBerkala\Models\\';

  public function index(string $category): string
  {
    $themodel = model($this->modelPrefix . 'InformasiBerkalaModel');


    $data = $themodel->where('category', strtoupper(str_replace("-", " ", $category)))->findAll();

    $menu = array(
      "LAPORAN LHKPN" => "laporan-lhkpn",
      "LAPORAN ASET" => "laporan-aset",
      "KESELAMATAN & KESEHATAN" => "keselamatan-&-kesehatan",
      "LAPORAN DUMAS" => "laporan-dumas",
      "REKAP PENGADUAN" => "rekap-pengaduan",
    );

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
      'title' => 'INFORMASI BERKALA',
      'content' => $content,
      'menu' => $menu,
      'header' => $header,
      'subtitle' => strtoupper(str_replace("-", " ", $category))
    ]);
  }
}
