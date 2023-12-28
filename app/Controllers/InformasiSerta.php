<?php

namespace App\Controllers;


class InformasiSerta extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiSerta\Models\\';

  public function index(string $category): string
  {
    $themodel = model($this->modelPrefix . 'InformasiSertaModel');


    $data = $themodel->where('category', strtoupper(str_replace("-", " ", $category)))->findAll();

    $menu = array(
      "PENCEGAHAN COVID19" => "pencegahan-covid19",
      "PENYAKIT MULUT DAN KUKU" => "penyakit-mulut-dan-kuku",
      "PENYAKIT ZOONOSIS LAINNYA" => "penyakit-zoonosis-lainnya",
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
      'title' => 'INFORMASI SERTA',
      'content' => $content,
      'menu' => $menu,
      'header' => $header,
      'subtitle' => strtoupper(str_replace("-", " ", $category))
    ]);
  }
}
