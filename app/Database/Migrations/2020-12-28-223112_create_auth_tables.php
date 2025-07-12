<?php

declare(strict_types=1);

namespace CodeIgniter\Shield\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;
use CodeIgniter\Shield\Config\Auth;

class CreateAuthTables extends Migration
{
    private array $tables;
    private array $attributes;

    public function __construct(?Forge $forge = null)
    {
        $authConfig = config('Auth');

        if ($authConfig->DBGroup !== null) {
            $this->DBGroup = $authConfig->DBGroup;
        }

        parent::__construct($forge);

        $this->tables     = $authConfig->tables;
        $this->attributes = ($this->db->getPlatform() === 'MySQLi') ? ['ENGINE' => 'InnoDB'] : [];
    }

    public function up(): void
    {
        // Users Table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'username'       => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'status'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'         => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'last_active'    => ['type' => 'datetime', 'null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->createTable($this->tables['users']);

        // Auth Identities Table
        $this->forge->addField([
            'id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'type'         => ['type' => 'varchar', 'constraint' => 255],
            'name'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'secret'       => ['type' => 'varchar', 'constraint' => 255],
            'secret2'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'expires'      => ['type' => 'datetime', 'null' => true],
            'extra'        => ['type' => 'text', 'null' => true],
            'force_reset'  => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'last_used_at' => ['type' => 'datetime', 'null' => true],
            'created_at'   => ['type' => 'datetime', 'null' => true],
            'updated_at'   => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['type', 'secret']);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->createTable($this->tables['identities']);

        // Auth Login Attempts Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'id_type'    => ['type' => 'varchar', 'constraint' => 255],
            'identifier' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_type', 'identifier']);
        $this->forge->addKey('user_id');
        $this->createTable($this->tables['logins']);

        // Auth Token Login Attempts Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'id_type'    => ['type' => 'varchar', 'constraint' => 255],
            'identifier' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['id_type', 'identifier']);
        $this->forge->addKey('user_id');
        $this->createTable($this->tables['token_logins']);

        // Auth Remember Tokens (remember-me) Table
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'selector'        => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'expires'         => ['type' => 'datetime'],
            'created_at'      => ['type' => 'datetime', 'null' => false],
            'updated_at'      => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('selector');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->createTable($this->tables['remember_tokens']);

        // Auth Groups Table (Paste the provided code here)
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
            'description' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->createTable($this->tables['groups']);

        // Groups Users Table (existing - adjust foreign key for the new groups table)
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'group'      => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        // This is the crucial part: ensure 'group' column links to 'name' in auth_groups
        $this->forge->addForeignKey('group', $this->tables['groups'], 'name', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->forge->addUniqueKey(['user_id', 'group']);
        $this->createTable($this->tables['groups_users']);

        // Users Permissions Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'permission' => ['type' => 'varchar', 'constraint' => 255, 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', $this->tables['users'], 'id', '', 'CASCADE');
        $this->createTable($this->tables['permissions_users']);
    }

    public function down(): void
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable($this->tables['logins'], true);
        $this->forge->dropTable($this->tables['token_logins'], true);
        $this->forge->dropTable($this->tables['remember_tokens'], true);
        $this->forge->dropTable($this->tables['identities'], true);
        $this->forge->dropTable($this->tables['groups_users'], true);
        $this->forge->dropTable($this->tables['permissions_users'], true);
        $this->forge->dropTable($this->tables['groups'], true); // Add this line to drop the groups table
        $this->forge->dropTable($this->tables['users'], true);

        $this->db->enableForeignKeyChecks();
    }

    private function createTable(string $tableName): void
    {
        $this->forge->createTable($tableName, false, $this->attributes);
    }
}