<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Topup;

class TopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topup::create([
            'id_peminjam' => 1,
            'jumlah' => 150000,
            'tanggal_topup' => '2025-05-27 11:31:20',
        ]);
    }
}
