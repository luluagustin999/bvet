<?php

namespace App\Modules\Profile\Laboratorium\Bioteknologi\Models;

use CodeIgniter\Model;
use stdClass;

class BioteknologiModel extends Model
{
  protected $table      = 'bioteknologi';
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
        'label' => lang('Bioteknologi.title'),
        'rules' => 'required|min_length[1]|max_length[250]'
      ],
      'content'  => [
        'label' => lang('Bioteknologi.content'),
        'rules' => 'required|min_length[10]'
      ],
    ];
  }

  /**
   * create empty database entry
   */
  public function newBioteknologi(): object
  {
    $bioteknologi = new stdClass();
    foreach ($this->allowedFields as $field) {
      $bioteknologi->$field = null;
    }
    return $bioteknologi;
  }
}
