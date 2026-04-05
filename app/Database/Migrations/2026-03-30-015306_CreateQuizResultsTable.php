<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizResultsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_quiz_results'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_quiz'                      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_users'                     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah_benar_quiz_results'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'jumlah_salah_quiz_results'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'nilai_quiz_results'           => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'waktu_selesai_quiz_results'   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'created_at'                   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'                   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_quiz_results', true);
        $this->forge->addKey('id_quiz');
        $this->forge->addKey('id_users');
        $this->forge->addForeignKey('id_quiz', 'quiz', 'id_quiz', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_users', 'users', 'id_users', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_results');
    }

    public function down()
    {
        $this->forge->dropTable('quiz_results');
    }
}