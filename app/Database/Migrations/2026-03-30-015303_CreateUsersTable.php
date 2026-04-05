<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_users'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_users'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'email_users'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'password_users'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'role_users'         => ['type' => 'ENUM', 'constraint' => ['admin', 'pengajar', 'peserta']],
            'fingerprint_device' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'action'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id_users', true);
        $this->forge->addUniqueKey('email_users');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}