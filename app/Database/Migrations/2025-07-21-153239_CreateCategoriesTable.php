<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'parent_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('category_id', true); // Primary Key
        $this->forge->addForeignKey('parent_category_id', 'Categories', 'category_id', 'CASCADE', 'CASCADE'); // Self-referencing FK
        $this->forge->createTable('Categories');
    }

    public function down()
    {
        $this->forge->dropTable('Categories');
    }
}