<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFullnameAndRoleToUsersTable extends Migration
{
    public function up()
    {
        // Add 'fullname' column if it doesn't exist
        if (! $this->db->fieldExists('fullname', 'users')) {
            $this->forge->addColumn('users', [
                'fullname' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                    'after'      => 'username', // Assuming 'username' exists in your users table
                ],
            ]);
        }

        // Add 'role' column if it doesn't exist
        if (! $this->db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'default'    => 'user',
                    // CHANGE THIS LINE: Use a column that *actually exists* in the 'users' table.
                    // 'username' is usually safe, or 'id'.
                    'after'      => 'fullname', // Position it after 'fullname' (if 'fullname' is added first)
                    // OR 'after' => 'username',
                    // OR 'after' => 'id', (very safe)
                ],
            ]);
        }
    }

    public function down()
    {
        // This will remove the columns if you ever rollback the migration
        if ($this->db->fieldExists('fullname', 'users')) {
            $this->forge->dropColumn('users', 'fullname');
        }
        if ($this->db->fieldExists('role', 'users')) {
            $this->forge->dropColumn('users', 'role');
        }
    }
}