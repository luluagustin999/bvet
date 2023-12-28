<?php

namespace App\Modules\Informasi\Umum\Agenda\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgendaTable extends Migration
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
      'tanggal' => [
        'type' => 'text',
        'null' => true,
      ],
      'kegiatan' => [
        'type' => 'text',
        'null' => true,
      ],
      'lokasi' => [
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
    $this->forge->createTable('agenda', true);
  }

  public function down()
  {
    $this->forge->dropTable('agenda', true);
  }
}
