<?php

namespace App\Modules\Informasi\Umum\ExternalLink\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExternalLinkTable extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type'           => 'int',
        'constraint'     => 11,
        'unsigned'       => true,
        'auto_increment' => true,
      ],
      'instansi' => [
        'type' => 'text',
        'null' => true,
      ],
      'alamat' => [
        'type' => 'text',
        'null' => true,
      ],
      'link' => [
        'type' => 'text',
        'null' => true,
      ],
      'created_at' => [
        'type' => 'datetime',
        'null' => false,
      ],
      'updated_at' => [
        'type' => 'datetime',
        'null' => false,
      ],
      'deleted_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('externallink', true);
  }

  public function down()
  {
    $this->forge->dropTable('externallink', true);
  }
}
