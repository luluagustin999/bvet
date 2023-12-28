<?php

namespace App\Modules\Profile\Laboratorium\Epidimiologi\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEpidimiologiTable extends Migration
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
    $this->forge->createTable('epidimiologi', true);
  }

  public function down()
  {
    $this->forge->dropTable('epidimiologi', true);
  }
}
