<?php

namespace App\Modules\Profile\SDM\StrukturOrganisasi\Models;

use CodeIgniter\Model;
use stdClass;

class StrukturOrganisasiModel extends Model
{
  protected $table      = 'strukturorganisasi';
  protected $primaryKey = 'id';

  protected $returnType = 'object'; // default array



  protected $allowedFields = [
    'title',
    'content',
  ];

  protected $validationRules = [];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  public function __construct()
  {
    parent::__construct();


    $this->validationRules = [
      'id' => [
        // Needed for the id in email test;
        // see https://codeigniter4.github.io/userguide/installation/upgrade_435.html
        'rules' => 'permit_empty|is_natural_no_zero',
      ],
      'title'    => [
        'label' => lang('StrukturOrganisasi.title'),
        'rules' => 'required|min_length[1]|max_length[250]'
      ],
      'content'  => [
        'label' => lang('StrukturOrganisasi.content'),
        'rules' => 'required|min_length[10]'
      ],
    ];
  }

  /**
   * create empty database entry
   */
  public function newStrukturOrganisasi(): object
  {
    $strukturorganisasi = new stdClass();
    foreach ($this->allowedFields as $field) {
      $strukturorganisasi->$field = null;
    }
    return $strukturorganisasi;
  }
}
