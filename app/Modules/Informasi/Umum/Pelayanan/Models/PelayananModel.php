<?php

namespace App\Modules\Informasi\Umum\Pelayanan\Models;

use CodeIgniter\Model;
use stdClass;

class PelayananModel extends Model
{
  protected $table      = 'pelayanan';
  protected $primaryKey = 'id';

  protected $returnType = 'object'; // default array
  protected $useSoftDeletes = true;


  protected $allowedFields = [
    'title',
    'content',
    'excerpt',
    'image',
    'slug',
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
      'title'    => [
        'label' => lang('Pelayanan.title'),
        'rules' => 'required|max_length[250]'
      ],
      'image'  => [
        'label' => 'Imgae',
        'rules' => 'required|min_length[1]'
      ],
      'content'  => [
        'label' => lang('Pelayanan.content'),
        'rules' => 'required|min_length[100]'
      ],
      'excerpt' => [
        'label' => lang('Pelayanan.excerpt'),
        'rules' => 'required|min_length[10]|max_length[250]'
      ],
      'slug'     => [
        'label' => lang('Pelayanan.urlSlug'),
        'rules' => 'permit_empty|valid_url|is_unique[pelayanan.slug,id,{id}]|min_length[3]|max_length[250]'
      ],

    ];
  }

  /**
   * create empty database entry
   */
  public function newPage(): object
  {
    $pelayanan = new stdClass();
    foreach ($this->allowedFields as $field) {
      $pelayanan->$field = null;
    }
    return $pelayanan;
  }
}
