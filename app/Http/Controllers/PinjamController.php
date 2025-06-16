<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Peminjam;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjams = DB::table('pinjams')
            ->join('peminjams',     'pinjams.id_peminjam', '=', 'peminjams.id')
            ->join('salinan_bukus', 'pinjams.id_salinan',  '=', 'salinan_bukus.id')
            ->join('bukus',         'salinan_bukus.id_buku','=', 'bukus.id')
            ->select(
                'pinjams.*',
                'peminjams.nama  AS peminjam',
                'bukus.judul'
            )
            ->whereNull('pinjams.tanggal_kembali')
            ->orderByDesc('pinjams.id')
            ->get();

        $bookings = DB::table('bookings')
            ->join('peminjams', 'bookings.id_peminjam', '=', 'peminjams.id')
            ->join('bukus',     'bookings.id_buku',     '=', 'bukus.id')
            ->select(
                'bookings.*',
                'peminjams.nama AS peminjam',
                'bukus.judul'
            )
            ->where('bookings.status', 'menunggu')
            ->orderByDesc('bookings.id')
            ->get();

        $bukus = DB::table('bukus')
            ->join('salinan_bukus', 'bukus.id', '=', 'salinan_bukus.id_buku')
            ->where('salinan_bukus.status', 'tersedia')
            ->select('bukus.id', 'bukus.judul')
            ->distinct()
            ->get();

        return view('pinjam.index', compact('pinjams', 'bookings', 'bukus'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Buku $buku)
    {
        $salinan = $buku->salinanTersedia()->first();

        if (!$salinan) {
            return back()->with('error', 'Tidak ada salinan tersedia.');
        }

        $peminjamId = session('peminjam_id');

        if (!$peminjamId) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        // Ambil data peminjam dari database
        $peminjam = DB::table('peminjams')->find($peminjamId);

        if (!$peminjam) {
            return redirect()->route('login')->withErrors(['login' => 'Peminjam tidak ditemukan.']);
        }

        return view('pinjam.create', compact('buku', 'salinan', 'peminjam'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::statement('CALL pinjam_buku(?, ?, ?, ?)', [
                $request->id_salinan,
                session('peminjam_id'),
                $request->tanggal_pinjam,
                $request->tanggal_kembali,
            ]);

            return redirect()->route('dashboard.index')->with('success', 'Peminjaman berhasil.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal meminjam buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function riwayat()
    {
        $peminjamId = session('peminjam_id'); 

        $pinjaman = DB::table('pinjams')
            ->join('salinan_bukus', 'pinjams.id_salinan', '=', 'salinan_bukus.id')
            ->join('bukus', 'salinan_bukus.id_buku', '=', 'bukus.id')
            ->select('pinjams.*', 'bukus.judul', 'salinan_bukus.kode_salinan')
            ->where('pinjams.id_peminjam', $peminjamId)
            ->whereNull('pinjams.tanggal_kembali')
            ->get();

        return view('pinjam.riwayat', compact('pinjaman'));
    }
    public function show(Pinjam $pinjam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pinjam $pinjam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pinjam $pinjam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pinjam $pinjam)
    {
        //
    }

    public function prosesPeminjaman(Request $request)
    {
        if (!session()->has('peminjam_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk meminjam.');
        }

        $idPeminjam = session('peminjam_id');
        $idBuku = $request->input('id_buku');
        $tanggalPinjam = Carbon::now()->toDateString();

        try {
            DB::statement("CALL spProsesPeminjaman(?, ?, ?)", [$idPeminjam, $idBuku, $tanggalPinjam]);
            return redirect()->back()->with('success', 'Peminjaman berhasil diproses.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses peminjaman: ' . $e->getMessage());
        }
    }


    public function prosesPengembalian($idPinjam)
    {
        DB::statement("CALL spProsesPengembalian(?, ?)", [$idPinjam, Carbon::now()]);
        return redirect()->back()->with('success', 'Pengembalian berhasil diproses.');
    }

    public function bookingKePinjam($idBooking)
    {
        DB::statement("CALL spBookingKePinjam(?)", [$idBooking]);
        return redirect()->back()->with('success', 'Booking berhasil dikonversi ke peminjaman.');
    }
}
