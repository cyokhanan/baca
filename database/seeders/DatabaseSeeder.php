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
        $now   = Carbon::now();
        $today = Carbon::create(2025, 6, 17);

        DB::table('penulis')->insert([
            ['nama' => 'Andrea Hirata',            'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Dewi Lestari',             'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Tere Liye',                'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Habiburrahman El Shirazy', 'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Pramoedya Ananta Toer',    'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('kategoris')->insert([
            ['nama' => 'Fiksi',        'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Romansa',      'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Petualangan',  'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Biografi',     'created_at' => $now, 'updated_at' => $now],
            ['nama' => 'Ilmiah',       'created_at' => $now, 'updated_at' => $now],
        ]);

        $bukus = [
            ['judul' => 'Laskar Pelangi',      'id_kategori' => 1, 'rating_bintang' => 5],
            ['judul' => 'Sang Pemimpi',        'id_kategori' => 1, 'rating_bintang' => 4],
            ['judul' => 'Edensor',             'id_kategori' => 1, 'rating_bintang' => 4],
            ['judul' => 'Supernova',           'id_kategori' => 1, 'rating_bintang' => 5],
            ['judul' => 'Rindu',               'id_kategori' => 2, 'rating_bintang' => 4],
            ['judul' => 'Ayat Ayat Cinta',     'id_kategori' => 2, 'rating_bintang' => 5],
            ['judul' => 'Negeri Para Bedebah', 'id_kategori' => 3, 'rating_bintang' => 4],
            ['judul' => 'Perahu Kertas',       'id_kategori' => 2, 'rating_bintang' => 3],
            ['judul' => 'Pulang',              'id_kategori' => 3, 'rating_bintang' => 4],
            ['judul' => 'Bumi Manusia',        'id_kategori' => 1, 'rating_bintang' => 5],
        ];

        foreach ($bukus as $b) {
            $b['biaya_sewa'] = $b['rating_bintang'] * 1000;
            $b['created_at'] = $now;
            $b['updated_at'] = $now;
            DB::table('bukus')->insert($b);
        }

        $mapPenulis = [
            1  => [1], 2  => [1], 3  => [1],
            4  => [2], 5  => [3], 6  => [4],
            7  => [3], 8  => [2], 9  => [3],
            10 => [5],
        ];

        foreach ($mapPenulis as $bukuId => $penulisIds) {
            foreach ($penulisIds as $pid) {
                DB::table('tim_penulis')->insert([
                    'id_buku'   => $bukuId,
                    'id_penulis'=> $pid,
                ]);
            }
        }

        foreach (DB::table('bukus')->get() as $buku) {
            $prefix = Str::upper(substr(Str::slug($buku->judul, ''), 0, 4));
            for ($i = 1; $i <= rand(3, 5); $i++) {
                DB::table('salinan_bukus')->insert([
                    'id_buku'      => $buku->id,
                    'kode_salinan' => $prefix . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'status'       => 'tersedia',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }
        }

        DB::table('peminjams')->insert([
            [
                'nama' => 'Felix Tanuwijaya', 'email' => 'felix.tanu@gmail.com',
                'telepon' => '081212345678',  'alamat' => 'Jakarta Utara',
                'password' => Hash::make('password'), 'deposit' => 60000,
                'status_blacklist' => 0, 'blacklist_until' => null,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Livia Gunawan', 'email' => 'livia.gunawan@gmail.com',
                'telepon' => '082112345679', 'alamat' => 'Surabaya',
                'password' => Hash::make('password'), 'deposit' => 75000,
                'status_blacklist' => 0, 'blacklist_until' => null,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Kevin Hartanto', 'email' => 'kevinhartanto88@gmail.com',
                'telepon' => '081345678912', 'alamat' => 'Bandung',
                'password' => Hash::make('password'), 'deposit' => 70000,
                'status_blacklist' => 0, 'blacklist_until' => null,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Melinda Wijaya', 'email' => 'melindawijaya21@gmail.com',
                'telepon' => '082233445566', 'alamat' => 'Jakarta Barat',
                'password' => Hash::make('password'), 'deposit' => 85000,
                'status_blacklist' => 0, 'blacklist_until' => null,
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'nama' => 'Jonathan Lie', 'email' => 'jonathanlie77@gmail.com',
                'telepon' => '081223344556', 'alamat' => 'Semarang',
                'password' => Hash::make('password'), 'deposit' => 90000,
                'status_blacklist' => 0, 'blacklist_until' => null,
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);

        DB::table('topups')->insert([
            'id_peminjam' => 1,
            'jumlah'      => 25000,
            'tanggal'     => $now,
            'created_at'  => $now,
            'updated_at'  => $now,
        ]);

        $salinan         = DB::table('salinan_bukus')->take(10)->get();
        $peminjamIds     = DB::table('peminjams')->pluck('id')->all();
        $blacklistUpdate = [];

        foreach ($salinan as $idx => $copy) {
            $peminjamId       = $peminjamIds[$idx % count($peminjamIds)];
            $status           = 'dikembalikan';
            $tanggalPinjam    = (clone $today)->subDays(rand(10, 15));
            $tanggalJatuhTempo= (clone $tanggalPinjam)->addDays(7);
            $tanggalKembali   = (clone $tanggalJatuhTempo)->subDays(rand(0, 2));

            if ($peminjamId == 3 && $idx == 2) {
                $status         = 'terlambat';
                $tanggalKembali = (clone $tanggalJatuhTempo)->addDays(2);
                $daysLate       = $tanggalKembali->diffInDays($tanggalJatuhTempo);
                $blacklistDays  = $daysLate * 2;
                $blacklistUpdate[$peminjamId] = [
                    'status_blacklist' => 1,
                    'blacklist_until'  => (clone $today)->addDays($blacklistDays),
                ];
            }

            DB::table('pinjams')->insert([
                'id_peminjam'        => $peminjamId,
                'id_salinan'         => $copy->id,
                'tanggal_pinjam'     => $tanggalPinjam,
                'tanggal_jatuh_tempo'=> $tanggalJatuhTempo,
                'tanggal_kembali'    => $status === 'dipinjam' ? null : $tanggalKembali,
                'status'             => $status,
                'denda_kerusakan'    => 0,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }

        foreach ($blacklistUpdate as $id => $data) {
            DB::table('peminjams')->where('id', $id)->update([
                'status_blacklist' => $data['status_blacklist'],
                'blacklist_until'  => $data['blacklist_until'],
                'updated_at'       => $now,
            ]);
        }
    }
}
