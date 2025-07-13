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
                    'null'       => true, // Or false, depending on your requirement
                    'after'      => 'username', // Position it after username
                ],
            ]);
        }

        // Add 'role' column if it doesn't exist
        if (! $this->db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'default'    => 'user', // Default role for new registrations
                    'after'      => 'password_hash', // Position it after password_hash
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