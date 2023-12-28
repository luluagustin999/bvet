<?php

namespace App\Modules\Informasi\Veteriner\SertifikatHasil\Models;

use CodeIgniter\Model;
use stdClass;

class SertifikatHasilModel extends Model
{
  protected $table      = 'sertifikathasil';
  protected $primaryKey = 'id';

  protected $returnType = 'object'; // default array

  protected $allowedFields = [
    'title',
    'link',
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
        'label' => lang('SertifikatHasil.title'),
        'rules' => 'required|min_length[1]|max_length[250]'
      ],
      'link'  => [
        'label' => 'Link',
        'rules' => 'required'
      ],
    ];
  }

  /**
   * create empty database entry
   */
  public function newSertifikatHasil(): object
  {
    $sertifikathasil = new stdClass();
    foreach ($this->allowedFields as $field) {
      $sertifikathasil->$field = null;
    }
    return $sertifikathasil;
  }
}
