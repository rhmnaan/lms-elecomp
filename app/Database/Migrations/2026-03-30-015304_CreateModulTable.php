<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_modul'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_kelas'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_modul'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'urutan_modul' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_modul', true);
        $this->forge->addKey('id_kelas');
        $this->forge->addForeignKey('id_kelas', 'kelas', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('modul');
    }

    public function down()
    {
        $this->forge->dropTable('modul');
    }
}