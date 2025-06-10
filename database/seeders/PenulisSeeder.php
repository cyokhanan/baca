<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penulis;

class PenulisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penulis::create(['nama' => 'Andrea Hirata']);
        Penulis::create(['nama' => 'Tere Liye']);
        Penulis::create(['nama' => 'Raditya Dika']);
    }
}
