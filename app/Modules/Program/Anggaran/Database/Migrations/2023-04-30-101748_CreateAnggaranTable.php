<?php

namespace App\Modules\Program\Anggaran\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggaranTable extends Migration
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
      'deskripsi' => [
        'type' => 'text',
        'null' => true,
      ],
      'file' => [
        'type' => 'text',
        'null' => true,
      ],
      'category' => [
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
    $this->forge->createTable('anggaran', true);
  }

  public function down()
  {
    $this->forge->dropTable('anggaran', true);
  }
}
