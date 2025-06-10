<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peminjam;

class PeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Peminjam::create([
            'nama' => 'Dewi Lestari',
            'email' => 'dewi.lestari@gmail.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Kenanga No. 15, Surabaya, Jawa Timur',
            'deposit' => 150000,
            'status_blacklist' => false,
        ]);
    }
}
