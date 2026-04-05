<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_materi'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_modul'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_materi'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'isi_materi'        => ['type' => 'TEXT', 'null' => true],
            'file_materi'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'video_url_materi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_materi', true);
        $this->forge->addKey('id_modul');
        $this->forge->addForeignKey('id_modul', 'modul', 'id_modul', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materi');
    }

    public function down()
    {
        $this->forge->dropTable('materi');
    }
}