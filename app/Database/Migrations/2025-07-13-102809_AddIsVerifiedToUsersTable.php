<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsVerifiedToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'is_verified' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'password_hash', // Or any appropriate column
            ],
            'verification_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'is_verified',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['is_verified', 'verification_hash']);
    }
}