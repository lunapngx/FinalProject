<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomFieldsToShieldUsers extends Migration
{
    public function up()
    {
        // Add 'first_name' column
        $this->forge->addColumn('users', [
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
                'after'      => 'username', // Or 'id', or whatever suits your order
            ],
        ]);

        // Add 'last_name' column
        $this->forge->addColumn('users', [
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
                'after'      => 'first_name',
            ],
        ]);

        // Add 'phone_number' column
        $this->forge->addColumn('users', [
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'last_name',
            ],
        ]);

        // Add 'user_type' column (using ENUM for MySQL)
        // Note: CodeIgniter's Forge class handles ENUM types correctly for MySQL
        $this->forge->addColumn('users', [
            'user_type' => [
                'type'       => 'ENUM',
                'constraint' => ['customer', 'admin'],
                'null'       => false,
                'default'    => 'customer', // Default for new users
                'after'      => 'phone_number',
            ],
        ]);

        // Add 'last_login_at' column
        $this->forge->addColumn('users', [
            'last_login_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'updated_at', // After CI's default updated_at
            ],
        ]);
    }

    public function down()
    {
        // Drop the columns in the reverse order of adding them
        $this->forge->dropColumn('users', 'last_login_at');
        $this->forge->dropColumn('users', 'user_type');
        $this->forge->dropColumn('users', 'phone_number');
        $this->forge->dropColumn('users', 'last_name');
        $this->forge->dropColumn('users', 'first_name');
    }
}