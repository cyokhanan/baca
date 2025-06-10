<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pinjam;

class PinjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pinjam::create([
            'id_peminjam' => 1,
            'id_salinan' => 1,
            'tanggal_pinjam' => '2025-06-03',
            'tanggal_jatuh_tempo' => '2025-06-10',
            'tanggal_kembali' => null,
            'denda_kerusakan' => 0,
            'biaya_sewa' => 3000,
        ]);
    }
}
