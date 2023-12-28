<?php

namespace App\Modules\Informasi\Veteriner\PengaduanMasyarakat\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduanMasyarakatTable extends Migration
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
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('pengaduanmasyarakat', true);
  }

  public function down()
  {
    $this->forge->dropTable('pengaduanmasyarakat', true);
  }
}
