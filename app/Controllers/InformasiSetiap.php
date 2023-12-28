<?php

namespace App\Controllers;


class InformasiSetiap extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Veteriner\InformasiSetiap\Models\\';

  public function index(string $category): string
  {
    $themodel = model($this->modelPrefix . 'InformasiSetiapModel');


    $data = $themodel->where('category', strtoupper(str_replace("-", " ", $category)))->findAll();

    $menu = array(
      "LAPORAN PERJANJIAN KERJASAMA" => "laporan-perjanjian-kerjasama",
      "LAPORAN SURAT MENYURAT" => "laporan-surat-menyurat",
      "HASIL PENELITIAN" => "hasil-penelitian",
      "INFORMASI REGULASI" => "informasi-regulasi",
      "PERSYARATAN PERIZINAN" => "persyaratan-perizinan",
      "DAFTAR INFORMASI PUBLIK" => "daftar-informasi-publik",
      "DAFTAR INFORMASI DIKECUALIKAN" => "daftar-informasi-dikecualikan",
      "DAFTAR RENCANA KEBIJAKAN" => "daftar-rencana-kebijakan",
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
      'title' => 'INFORMASI SETIAP SAAT',
      'content' => $content,
      'menu' => $menu,
      'header' => $header,
      'subtitle' => strtoupper(str_replace("-", " ", $category))
    ]);
  }
}
