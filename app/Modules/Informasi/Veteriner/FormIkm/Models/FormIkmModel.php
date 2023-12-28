<?php

namespace App\Modules\Informasi\Veteriner\FormIkm\Models;

use CodeIgniter\Model;
use stdClass;

class FormIkmModel extends Model
{
  protected $table      = 'formikm';
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
        'label' => lang('FormIkm.title'),
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
  public function newFormIkm(): object
  {
    $formikm = new stdClass();
    foreach ($this->allowedFields as $field) {
      $formikm->$field = null;
    }
    return $formikm;
  }
}
