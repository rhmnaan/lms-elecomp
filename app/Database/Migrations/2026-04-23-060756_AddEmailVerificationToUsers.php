<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailVerificationToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'email_verified' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
                'after'      => 'email_users',
            ],
            'verification_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'after'      => 'email_verified',
            ],
            'token_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'verification_token',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'email_verified',
            'verification_token',
            'token_expires_at'
        ]);
    }
}