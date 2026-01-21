<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentChannels extends Migration
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
            'bank_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'account_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'account_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'deleted_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('bank_id', 'banks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payment_channels');

        // Catatan: Seeding bergantung pada banks yang sudah ada. Karena migrasi banks mengisi data, ini seharusnya aman jika dijalankan berurutan.
        // Saya berasumsi ID bank 1, 2, 3, 4 ada dari migrasi CreateBanks.
        $this->seed();
    }

    public function down()
    {
        $this->forge->dropTable('payment_channels');
    }

    private function seed()
    {
        // Asumsi Banks sudah di-seed: 1=BCA, 2=Mandiri, dll.
        $data = [
            [
                'bank_id'        => 1, // BCA
                'account_name'   => 'PT Biovue Indonesia',
                'account_number' => '1234567890',
                'status'         => 'active',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'bank_id'        => 2, // Mandiri
                'account_name'   => 'PT Biovue Indonesia',
                'account_number' => '0987654321',
                'status'         => 'active',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        // Hanya insert jika tabel banks tidak kosong untuk menghindari error FK di mode strict
        if ($this->db->table('banks')->countAllResults() > 0) {
             $this->db->table('payment_channels')->insertBatch($data);
        }
    }
}
