<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('PageSeeder');
        // Tambahkan seeder lain di sini jika ada (misal: BankSeeder, PlanSeeder, dll.)
    }
}
