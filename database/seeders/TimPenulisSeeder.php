<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimPenulis;

class TimPenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimPenulis::create([
            'id_buku' => 1,
            'id_penulis' => 1,
        ]);
        TimPenulis::create([
            'id_buku' => 2,
            'id_penulis' => 2,
        ]);
    }
}
