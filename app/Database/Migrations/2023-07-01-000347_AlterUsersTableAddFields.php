<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableAddFields extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('users', [
            'first_name' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'last_name' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'mobile' => [
                'type' => 'varchar',
                'constraint' => 15,
            ],
        ]);

        $this->forge->addUniqueKey('mobile');
    }

    public function down(): void
    {
        $this->forge->dropColumn('users', [
            'first_name',
            'last_name',
            'mobile',
        ]);
    }
}
