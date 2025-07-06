<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'description' => [ // Optional: if you have a description column
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [ // Only if useTimestamps is true in your model
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [ // Only if useTimestamps is true in your model
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            // Add any other fields from your CategoryModel's $allowedFields
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}