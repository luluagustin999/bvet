<?php

namespace App\Modules\Informasi\Aplikasi\Models;

use CodeIgniter\Model;
use stdClass;

class AplikasiModel extends Model
{
  protected $table      = 'aplikasi';
  protected $primaryKey = 'id';

  protected $returnType = 'object'; // default array
  protected $useSoftDeletes = true;


  protected $allowedFields = [
    'layanan',
    'link',
    'deleted_at'
  ];

  protected $validationRules = [];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deleted_at    = 'deleted_at';

  public function __construct()
  {
    parent::__construct();


    $this->validationRules = [
      'id' => [
        // Needed for the id in email test;
        // see https://codeigniter4.github.io/userguide/installation/upgrade_435.html
        'rules' => 'permit_empty|is_natural_no_zero',
      ],
      'layanan'  => [
        'label' => 'Layanan',
        'rules' => 'required'
      ],
      'link'  => [
        'label' => 'Link',
        'rules' => 'required|min_length[1]'
      ],

    ];
  }

  /**
   * create empty database entry
   */
  public function newPage(): object
  {
    $aplikasi = new stdClass();
    foreach ($this->allowedFields as $field) {
      $aplikasi->$field = null;
    }
    return $aplikasi;
  }
}
