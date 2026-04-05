<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahKolomUpdateAt extends Migration
{
    public function up()
    {
        $tables = [
            'kelas',
            'kelas_peserta',
            'materi',
            'modul',
            'quiz',
            'quiz_questions',
            'quiz_results',
            'users'
        ];

        foreach ($tables as $table) {
            // Tambah updated_at kalau belum ada
            $this->forge->addColumn($table, [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        $tables = [
            'kelas',
            'kelas_peserta',
            'materi',
            'modul',
            'quiz',
            'quiz_questions',
            'quiz_results',
            'users'
        ];

        foreach ($tables as $table) {
            $this->forge->dropColumn($table, 'updated_at');
        }
    }
}