<?php

namespace App\Modules\Informasi\Veteriner\InformasiSerta\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInformasiSertaTable extends Migration
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
    $this->forge->createTable('informasiserta', true);
  }

  public function down()
  {
    $this->forge->dropTable('informasiserta', true);
  }
}
