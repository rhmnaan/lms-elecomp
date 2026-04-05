<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameMateriColumns extends Migration
{
    public function up()
    {
        // Rename isi_materi → pre_test
        $this->forge->modifyColumn('materi', [
            'isi_materi' => [
                'name'       => 'pre_test',
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => null,
            ],
        ]);

        // Rename quiz_data → post_test
        $this->forge->modifyColumn('materi', [
            'quiz_data' => [
                'name'       => 'post_test',
                'type'       => 'LONGTEXT',
                'null'       => true,
                'default'    => null,
            ],
        ]);
    }

    public function down()
    {
        // Rollback: kembalikan nama kolom semula
        $this->forge->modifyColumn('materi', [
            'pre_test' => [
                'name'    => 'isi_materi',
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
            ],
        ]);

        $this->forge->modifyColumn('materi', [
            'post_test' => [
                'name'    => 'quiz_data',
                'type'    => 'LONGTEXT',
                'null'    => true,
                'default' => null,
            ],
        ]);
    }
}