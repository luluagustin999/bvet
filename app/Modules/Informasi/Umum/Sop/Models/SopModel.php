<?php

namespace App\Modules\Informasi\Umum\Sop\Models;

use CodeIgniter\Model;
use stdClass;

class SopModel extends Model
{
  protected $table      = 'sop';
  protected $primaryKey = 'id';

  protected $returnType = 'object'; // default array
  protected $useSoftDeletes = true;


  protected $allowedFields = [
    'deskripsi',
    'file',
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
      'deskripsi'  => [
        'label' => 'Deskripsi',
        'rules' => 'required|min_length[10]'
      ],
      'file'  => [
        'label' => 'File',
        'rules' => 'required|min_length[1]'
      ],
    ];
  }

  /**
   * create empty database entry
   */
  public function newPage(): object
  {
    $sop = new stdClass();
    foreach ($this->allowedFields as $field) {
      $sop->$field = null;
    }
    return $sop;
  }
}
