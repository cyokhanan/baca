<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalinanBuku;

class SalinanBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kode = 'LAPE';
        foreach (range(1, 5) as $i) {
            SalinanBuku::create([
                'id_buku' => 1,
                'kode_salinan' => $kode . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'tersedia',
            ]);
        }
    }
}
