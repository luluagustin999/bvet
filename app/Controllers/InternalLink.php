<?php

namespace App\Controllers;


class InternalLink extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\InternalLink\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'InternalLinkModel');


    $data = $themodel->findAll();


    $header = ['Instansi', 'Alamat', 'Link Website', 'Kunjungi'];

    // Initialize an empty string for the HTML content
    $content = '';

    // Loop through the data and build the HTML string
    foreach ($data as $row) {
      $content .= "<tr>";
      $content .= "<td>" . esc($row->instansi) . "</td>"; // Replace 'column1' with your actual column name
      $content .= "<td>" . esc($row->alamat) . "</td>"; // Repeat for as many columns as you have
      $content .= "<td>" . esc($row->link) . "</td>"; // Repeat for as many columns as you have

      $content .= "<td>";
      $content .= "<a style='background: #7e589b;' href='" . $row->link . "' class='btn waves-effect waves-light btn-primary'>Download</a>";
      $content .= "</td>";

      $content .= "</tr>";
    }


    return $this->render('download', [
      'title' => 'INTERNAL LINK',
      'content' => $content,
      'header' => $header,
    ]);
  }
}
