<?php

namespace App\Modules\Profile\Instansi\KomitmenBersama\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKomitmenBersamaTable extends Migration
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
      'title' => [
        'type'       => 'varchar',
        'constraint' => 255,
      ],
      'content' => [
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
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('komitmenbersama', true);
  }

  public function down()
  {
    $this->forge->dropTable('komitmenbersama', true);
  }
}
