<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_kelas'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi_kelas' => ['type' => 'TEXT', 'null' => true],
            'id_users'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_kelas', true);
        $this->forge->addKey('id_users');
        $this->forge->addForeignKey('id_users', 'users', 'id_users', 'CASCADE', 'SET NULL');
        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}