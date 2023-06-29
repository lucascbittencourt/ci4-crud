<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'last_name' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '100',
                'unique' => true,
            ],
            'mobile' => [
                'type' => 'varchar',
                'constraint' => '15',
                'unique' => true,
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => '50',
                'unique' => true,
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down(): void
    {
        $this->forge->dropTable('users');
    }
}
