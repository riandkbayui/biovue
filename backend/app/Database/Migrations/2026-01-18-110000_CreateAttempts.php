<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttempts extends Migration
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
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Null jika login gagal dan user tidak ditemukan
            ],
            'user_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'success' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // 0: Gagal, 1: Berhasil
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id'); // Indexing untuk pencarian riwayat login user
        $this->forge->addKey('ip_address'); // Indexing untuk throttling check
        $this->forge->createTable('attempts');
    }

    public function down()
    {
        $this->forge->dropTable('attempts');
    }
}
