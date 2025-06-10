<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Buku::create([
            'judul' => 'Laskar Pelangi',
            'id_kategori' => 1,
            'tahun_terbit' => 2005,
            'harga_sewa' => 3000,
        ]);
        Buku::create([
            'judul' => 'Negeri Para Bedebah',
            'id_kategori' => 1,
            'tahun_terbit' => 2012,
            'harga_sewa' => 3500,
        ]);
    }
}
