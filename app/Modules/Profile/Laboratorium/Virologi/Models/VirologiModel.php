<?php

namespace App\Modules\Profile\Laboratorium\Virologi\Models;

use CodeIgniter\Model;
use stdClass;

class VirologiModel extends Model
{
  protected $table      = 'virologi';
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
        'label' => lang('Virologi.title'),
        'rules' => 'required|min_length[1]|max_length[250]'
      ],
      'content'  => [
        'label' => lang('Virologi.content'),
        'rules' => 'required|min_length[10]'
      ],
    ];
  }

  /**
   * create empty database entry
   */
  public function newVirologi(): object
  {
    $virologi = new stdClass();
    foreach ($this->allowedFields as $field) {
      $virologi->$field = null;
    }
    return $virologi;
  }
}
