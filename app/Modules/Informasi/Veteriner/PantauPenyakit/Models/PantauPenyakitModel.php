<?php

namespace App\Modules\Informasi\Veteriner\PantauPenyakit\Models;

use CodeIgniter\Model;
use stdClass;

class PantauPenyakitModel extends Model
{
  protected $table      = 'pantaupenyakit';
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
        'label' => lang('PantauPenyakit.title'),
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
  public function newPantauPenyakit(): object
  {
    $pantaupenyakit = new stdClass();
    foreach ($this->allowedFields as $field) {
      $pantaupenyakit->$field = null;
    }
    return $pantaupenyakit;
  }
}
