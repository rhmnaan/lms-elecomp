<?php
// app/Database/Migrations/2026-04-02-080001_CreateMateriQuizResultsTable.php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriQuizResultsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_materi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,  // ← wajib sama dengan tabel materi
                'null'       => false,
            ],
            'id_users' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,  // ← wajib sama dengan tabel users
                'null'       => false,
            ],
            'nilai' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'jumlah_benar' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'jumlah_salah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('id_materi');
        $this->forge->addKey('id_users');
        $this->forge->addForeignKey('id_materi', 'materi', 'id_materi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_users',  'users',  'id_users',  'CASCADE', 'CASCADE');

        $this->forge->createTable('materi_quiz_results', true);
    }

    public function down()
    {
        $this->forge->dropTable('materi_quiz_results', true);
    }
}