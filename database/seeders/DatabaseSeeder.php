<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('penulis')->insert([
            ['nama'=>'Andrea Hirata','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Dewi Lestari','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Tere Liye','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Habiburrahman El Shirazy','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Pramoedya Ananta Toer','created_at'=>$now,'updated_at'=>$now]
        ]);

        DB::table('kategoris')->insert([
            ['nama'=>'Fiksi','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Romansa','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Petualangan','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Biografi','created_at'=>$now,'updated_at'=>$now],
            ['nama'=>'Ilmiah','created_at'=>$now,'updated_at'=>$now]
        ]);

        $bukus=[
            ['judul'=>'Laskar Pelangi','id_kategori'=>1,'rating_bintang'=>5],
            ['judul'=>'Sang Pemimpi','id_kategori'=>1,'rating_bintang'=>4],
            ['judul'=>'Edensor','id_kategori'=>1,'rating_bintang'=>4],
            ['judul'=>'Supernova','id_kategori'=>1,'rating_bintang'=>5],
            ['judul'=>'Rindu','id_kategori'=>2,'rating_bintang'=>4],
            ['judul'=>'Ayat Ayat Cinta','id_kategori'=>2,'rating_bintang'=>5],
            ['judul'=>'Negeri Para Bedebah','id_kategori'=>3,'rating_bintang'=>4],
            ['judul'=>'Perahu Kertas','id_kategori'=>2,'rating_bintang'=>3],
            ['judul'=>'Pulang','id_kategori'=>3,'rating_bintang'=>4],
            ['judul'=>'Bumi Manusia','id_kategori'=>1,'rating_bintang'=>5]
        ];

        foreach($bukus as $b){
            $b['biaya_sewa']=$b['rating_bintang']*1000;
            $b['created_at']=$now;
            $b['updated_at']=$now;
            DB::table('bukus')->insert($b);
        }

        $mapPenulis=[
            1=>[1],
            2=>[1],
            3=>[1],
            4=>[2],
            5=>[3],
            6=>[4],
            7=>[3],
            8=>[2],
            9=>[3],
            10=>[5]
        ];

        foreach($mapPenulis as $bukuId=>$penulisIds){
            foreach($penulisIds as $pid){
                DB::table('tim_penulis')->insert([
                    'id_buku'=>$bukuId,
                    'id_penulis'=>$pid
                ]);
            }
        }

        foreach(DB::table('bukus')->get() as $buku){
            $prefix = Str::upper(substr(Str::slug($buku->judul,''),0,4));
            $maxSalinan = rand(3,5);
            for($i=1;$i<=$maxSalinan;$i++){
                $kode = $prefix.str_pad($i,3,'0',STR_PAD_LEFT);
                DB::table('salinan_bukus')->insert([
                    'id_buku'=>$buku->id,
                    'kode_salinan'=>$kode,
                    'status'=>'tersedia',
                    'created_at'=>$now,
                    'updated_at'=>$now
                ]);
            }
        }

        DB::table('peminjams')->insert([
            [
                'nama'=>'Budi Santoso',
                'email'=>'budi@example.com',
                'telepon'=>'081234567890',
                'alamat'=>'Jl. Kenanga 1',
                'password'=>Hash::make('password'),
                'deposit'=>50000,
                'created_at'=>$now,
                'updated_at'=>$now
            ],
            [
                'nama'=>'Sari Wulandari',
                'email'=>'sari@example.com',
                'telepon'=>'081234567891',
                'alamat'=>'Jl. Melati 2',
                'password'=>Hash::make('password'),
                'deposit'=>75000,
                'created_at'=>$now,
                'updated_at'=>$now
            ],
            [
                'nama'=>'Agus Pratama',
                'email'=>'agus@example.com',
                'telepon'=>'081234567892',
                'alamat'=>'Jl. Mawar 3',
                'password'=>Hash::make('password'),
                'deposit'=>60000,
                'created_at'=>$now,
                'updated_at'=>$now
            ],
            [
                'nama'=>'Dina Lestari',
                'email'=>'dina@example.com',
                'telepon'=>'081234567893',
                'alamat'=>'Jl. Cempaka 4',
                'password'=>Hash::make('password'),
                'deposit'=>80000,
                'created_at'=>$now,
                'updated_at'=>$now
            ],
            [
                'nama'=>'Rudi Hartono',
                'email'=>'rudi@example.com',
                'telepon'=>'081234567894',
                'alamat'=>'Jl. Anggrek 5',
                'password'=>Hash::make('password'),
                'deposit'=>90000,
                'created_at'=>$now,
                'updated_at'=>$now
            ]
        ]);

        DB::table('admins')->insert([
            'nama'=>'Admin Perpus',
            'email'=>'admin@perpus.local',
            'password'=>Hash::make('admin123'),
            'created_at'=>$now,
            'updated_at'=>$now
        ]);

        DB::table('topups')->insert([
            'id_peminjam'=>1,
            'jumlah'=>25000,
            'tanggal'=>$now,
            'created_at'=>$now,
            'updated_at'=>$now
        ]);
    }
}
