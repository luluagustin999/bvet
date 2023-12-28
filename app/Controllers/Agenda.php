<?php

namespace App\Controllers;


class Agenda extends BaseController
{
  protected $modelPrefix = 'App\Modules\Informasi\Umum\Agenda\Models\\';

  public function index(): string
  {
    $themodel = model($this->modelPrefix . 'AgendaModel');


    $data = $themodel->findAll();


    $header = ['Tanggal', 'Nama Kegiatan', 'Lokasi'];

    // Initialize an empty string for the HTML content
    $content = '';

    // Loop through the data and build the HTML string
    foreach ($data as $row) {
      $content .= "<tr>";
      $content .= "<td>" . esc($row->tanggal) . "</td>"; // Replace 'column1' with your actual column name
      $content .= "<td>" . esc($row->kegiatan) . "</td>"; // Repeat for as many columns as you have
      $content .= "<td>" . esc($row->lokasi) . "</td>"; // Repeat for as many columns as you have
      // ... Add more columns as needed
      $content .= "</tr>";
    }


    return $this->render('download', [
      'title' => 'AGENDA',
      'content' => $content,
      'header' => $header,
    ]);
  }
}
