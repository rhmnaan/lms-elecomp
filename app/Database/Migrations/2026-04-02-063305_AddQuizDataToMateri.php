<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQuizDataToMateri extends Migration
{
    public function up()
{
    $this->forge->addColumn('materi', [
        'quiz_data' => [
            'type'    => 'TEXT',
            'null'    => true,
            'default' => null,
            'after'   => 'video_url_materi',
        ],
    ]);
}

public function down()
{
    $this->forge->dropColumn('materi', 'quiz_data');
}
}
