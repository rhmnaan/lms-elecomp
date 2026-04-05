<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasPesertaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas_peserta'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_kelas'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_users'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_daftar_kelas_peserta' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'created_at'                   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'                   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_kelas_peserta', true);
        $this->forge->addKey('id_kelas');
        $this->forge->addKey('id_users');
        $this->forge->addForeignKey('id_kelas', 'kelas', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_users', 'users', 'id_users', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('kelas_peserta');
    }
}