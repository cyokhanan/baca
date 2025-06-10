<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PenulisSeeder::class,
            KategoriSeeder::class,
            BukuSeeder::class,
            TimPenulisSeeder::class,
            SalinanBukuSeeder::class,
            PeminjamSeeder::class,
            TopupSeeder::class,
            PinjamSeeder::class,
        ]);
    }
}
