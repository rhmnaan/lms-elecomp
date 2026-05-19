<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRisetEkspor extends Migration
{
    public function up()
    {
        // Tabel produk_ekspor
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_produk' => ['type' => 'VARCHAR', 'constraint' => 255],
            'hs_code'     => ['type' => 'VARCHAR', 'constraint' => 30,  'null' => true],
            'foto_1'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'foto_2'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'foto_3'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'foto_4'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('produk_ekspor');

        // Tabel negara_tujuan
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'produk_id'           => ['type' => 'INT', 'unsigned' => true],
            'negara'              => ['type' => 'VARCHAR', 'constraint' => 100],
            'alasan_pemilihan'    => ['type' => 'TEXT', 'null' => true],
            'persyaratan_ekspor'  => ['type' => 'TEXT', 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('produk_id', 'produk_ekspor', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('negara_tujuan');

        // Tabel buyer_ekspor
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'negara_tujuan_id' => ['type' => 'INT', 'unsigned' => true],
            'nama_perusahaan'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'alamat'           => ['type' => 'TEXT',    'null' => true],
            'website'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'no_hp'            => ['type' => 'VARCHAR', 'constraint' => 50,  'null' => true],
            'nama_pic'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('negara_tujuan_id', 'negara_tujuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buyer_ekspor');
    }

    public function down()
    {
        $this->forge->dropTable('buyer_ekspor',  true);
        $this->forge->dropTable('negara_tujuan', true);
        $this->forge->dropTable('produk_ekspor', true);
    }
}