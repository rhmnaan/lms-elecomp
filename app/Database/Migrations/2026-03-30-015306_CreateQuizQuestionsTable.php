<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizQuestionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_quiz_questions'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_quiz'                       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'pertanyaan_quiz_questions'     => ['type' => 'TEXT'],
            'pilihan_a_quiz_questions'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pilihan_b_quiz_questions'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pilihan_c_quiz_questions'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pilihan_d_quiz_questions'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jawaban_benar_quiz_questions'  => ['type' => 'CHAR', 'constraint' => 1, 'null' => true],
            'created_at'                    => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'                    => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_quiz_questions', true);
        $this->forge->addKey('id_quiz');
        $this->forge->addForeignKey('id_quiz', 'quiz', 'id_quiz', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_questions');
    }

    public function down()
    {
        $this->forge->dropTable('quiz_questions');
    }
}