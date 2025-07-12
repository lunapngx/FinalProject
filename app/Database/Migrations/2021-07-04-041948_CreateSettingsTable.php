<?php

namespace CodeIgniter\Settings\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;
use CodeIgniter\Settings\Config\Settings;

class CreateSettingsTable extends Migration
{
    private Settings $config;

    public function __construct(?Forge $forge = null)
    {
        $this->config  = config('Settings');
        $this->DBGroup = $this->config->database['group'] ?? null;

        parent::__construct($forge);
    }

    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'class' => [
                'type'       => 'VARCHAR',
                'constraint' => '191',
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '191',
            ],
            'value' => [
                'type' => 'TEXT',
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'string',
            ],
            'context' => [  // <--- LOOK FOR THIS ENTRY
                'type'       => 'VARCHAR',
                'constraint' => '191',
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['class', 'key', 'context']); // 'context' here also
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable($this->config->database['table']);
    }
}
