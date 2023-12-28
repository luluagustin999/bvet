<?php

namespace App\Controllers;


class LayananPpid extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\LayananPpid\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'LayananPpidModel');


    $data = $themodel->findAll();


    $header = ['Layanan', 'Link Website', 'Kunjungi'];

    // Initialize an empty string for the HTML content
    $content = '';

    // Loop through the data and build the HTML string
    foreach ($data as $row) {
      $content .= "<tr>";
      $content .= "<td>" . esc($row->layanan) . "</td>"; // Repeat for as many columns as you have
      $content .= "<td>" . esc($row->link) . "</td>"; // Repeat for as many columns as you have

      $content .= "<td>";
      $content .= "<a style='background: #7e589b;' href='" . $row->link . "' class='btn waves-effect waves-light btn-primary'>Download</a>";
      $content .= "</td>";

      $content .= "</tr>";
    }


    return $this->render('download', [
      'title' => 'LAYANAN PPID',
      'content' => $content,
      'header' => $header,
    ]);
  }
}
