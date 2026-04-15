<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideoEncryptedTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'video_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false,
                'comment'    => 'Nama file .enc tanpa ekstensi, cth: vid_abc123',
            ],
            'judul_video' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'default'    => '',
            ],
            'ext' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
                'default'    => 'mp4',
                'comment'    => 'Ekstensi asli sebelum dienkripsi',
            ],
            'size' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => false,
                'default'  => 0,
                'comment'  => 'Ukuran file .enc dalam byte',
            ],
            'id_users' => [
                'type'     => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null'     => false,
                'comment'  => 'FK ke tabel users (pengajar yang upload)',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('video_id');
        $this->forge->addKey('id_users');
        $this->forge->addKey('deleted_at');

        $this->forge->createTable('video_encrypted', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('video_encrypted', true);
    }
}