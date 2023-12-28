<?php

namespace App\Modules\Informasi\Veteriner\LaporanIkm\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanIkmTable extends Migration
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
    $this->forge->createTable('laporanikm', true);
  }

  public function down()
  {
    $this->forge->dropTable('laporanikm', true);
  }
}
