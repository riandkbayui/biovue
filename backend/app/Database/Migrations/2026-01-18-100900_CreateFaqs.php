<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqs extends Migration
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
            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'answer' => [
                'type' => 'TEXT',
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'general',
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
        $this->forge->createTable('faqs');

        $this->seed();
    }

    public function down()
    {
        $this->forge->dropTable('faqs');
    }

    private function seed()
    {
        $data = [
            [
                'question'   => 'Bagaimana cara membuat halaman baru?',
                'answer'     => 'Masuk ke dasbor Anda, lalu klik tombol "Buat Halaman Baru" dan masukkan judul serta slug yang Anda inginkan.',
                'category'   => 'Umum',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'question'   => 'Bisakah saya menggunakan domain kustom?',
                'answer'     => 'Ya, fitur domain kustom tersedia bagi pengguna paket Pro. Anda bisa mengaturnya di menu Pengaturan Halaman.',
                'category'   => 'Fitur',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'question'   => 'Bagaimana cara menambahkan elemen atau blok ke halaman?',
                'answer'     => 'Di dalam editor halaman, klik ikon "+" atau tombol "Tambah Blok", pilih jenis blok yang diinginkan (teks, gambar, tombol, dll), lalu atur posisinya.',
                'category'   => 'Editor',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'question'   => 'Apakah saya bisa mengubah tema halaman yang sudah dibuat?',
                'answer'     => 'Tentu, Anda dapat mengubah tema kapan saja melalui tab "Tema" di sisi editor tanpa kehilangan konten yang sudah ada.',
                'category'   => 'Editor',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'question'   => 'Metode pembayaran apa saja yang tersedia?',
                'answer'     => 'Saat ini kami mendukung transfer bank manual melalui bank-bank besar seperti BCA, Mandiri, BNI, dan BRI.',
                'category'   => 'Pembayaran',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'question'   => 'Bagaimana jika saya lupa kata sandi?',
                'answer'     => 'Klik tautan "Lupa Kata Sandi" di halaman login, masukkan email Anda, dan kami akan mengirimkan instruksi pemulihan.',
                'category'   => 'Akun',
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('faqs')->insertBatch($data);
    }
}
