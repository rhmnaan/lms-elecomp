<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_quiz'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_modul'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_quiz'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'deskripsi_quiz'      => ['type' => 'TEXT', 'null' => true],
            'waktu_mulai_quiz'    => ['type' => 'DATETIME', 'null' => true],
            'waktu_selesai_quiz'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'          => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_quiz', true);
        $this->forge->addKey('id_modul');
        $this->forge->addForeignKey('id_modul', 'modul', 'id_modul', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz');
    }

    public function down()
    {
        $this->forge->dropTable('quiz');
    }
}