<?php

namespace App\Controllers;


class RencanaKerja extends BaseController
{
  protected $modelPrefix = 'App\Modules\Program\RencanaKerja\Models\\';

  public function index(string $category): string
  {
    $themodel = model($this->modelPrefix . 'RencanaKerjaModel');


    $data = $themodel->where('category', strtoupper(str_replace("-", " ", $category)))->findAll();

    $menu = array(
      "RENCANA STRATEGIS" => "rencana-strategis",
      "RENCANA KERJA" => "rencana-kerja",
      "RKT/RBA" => "rkt",
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
      'title' => 'RENCANA KERJA',
      'content' => $content,
      'menu' => $menu,
      'header' => $header,
      'subtitle' => strtoupper(str_replace("-", " ", $category))
    ]);
  }
}
