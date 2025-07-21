<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsVerifiedToUsersTable extends Migration
{
    public function up()
    {
        // Add 'is_verified' and 'verification_hash' columns to the 'users' table
        $this->forge->addColumn('users', [
            'is_verified' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                // CHANGE THIS LINE: 'password_hash' does not exist in the 'users' table anymore.
                // Use a column that Shield's 'users' table *does* have.
                // Common choices: 'username', 'active', 'last_active', 'updated_at', 'id'.
                // If you added 'fullname' and 'role' in a previous migration, you could use 'role'.
                'after'      => 'active', // A good, general choice for Shield's users table
            ],
            'verification_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'is_verified', // This is fine as it refers to a column you're adding
            ],
        ]);
    }

    public function down()
    {
        // This will remove the columns if you ever rollback the migration
        $this->forge->dropColumn('users', ['is_verified', 'verification_hash']);
    }
}