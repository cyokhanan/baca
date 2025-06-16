<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
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
    public function create()
    {
        $peminjams = DB::table('peminjams')->select('id','nama')->get();
        $bukus     = DB::table('bukus')->select('id','judul')->get();
        return view('pinjam.create', compact('peminjams','bukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
