<?php

namespace App\Controllers;


class Kinerja extends BaseController
{
  protected $modelPrefix = 'App\Modules\Kinerja\Models\\';

  public function index(string $category): string
  {
    $themodel = model($this->modelPrefix . 'KinerjaModel');

    // First, replace hyphens with spaces
    $category = str_replace("-", " ", $category);

    // Next, replace underscores with slashes
    $category = str_replace("_", "/", $category);

    $data = $themodel->where('category', strtoupper($category))->findAll();

    $menu = array(
      "LAPORAN KEUANGAN" => "laporan-keuangan",
      "LAPORAN TAHUNAN" => "laporan-tahunan",
      "LAPORAN PPID" => "laporan-ppid",
      "LAPORAN KINERJA" => "laporan-kinerja",
      "LAPORAN IKM" => "laporan-ikm",
      "INFOGRAFIS KEUANGAN" => "infografis-keuangan",
      "CAPAIAN KERJA" => "capaian-kerja",
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
      'title' => 'KINERJA',
      'content' => $content,
      'menu' => $menu,
      'header' => $header,
      'subtitle' => strtoupper(str_replace("-", " ", $category))
    ]);
  }
}
