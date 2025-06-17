<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Peminjam;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SalinanBuku;

class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // daftar pinjaman aktif
        $pinjams = DB::table('pinjams')
            ->join('peminjams', 'pinjams.id_peminjam', '=', 'peminjams.id')
            ->join('salinan_bukus', 'pinjams.id_salinan', '=', 'salinan_bukus.id')
            ->join('bukus', 'salinan_bukus.id_buku', '=', 'bukus.id')
            ->select('pinjams.*', 'peminjams.nama as peminjam', 'bukus.judul')
            ->whereNull('pinjams.tanggal_kembali')
            ->orderByDesc('pinjams.id')
            ->get();

        // daftar booking yang menunggu salinan
        $bookings = DB::table('bookings')
            ->join('peminjams', 'bookings.id_peminjam', '=', 'peminjams.id')
            ->join('bukus', 'bookings.id_buku', '=', 'bukus.id')
            ->select('bookings.*', 'peminjams.nama as peminjam', 'bukus.judul')
            ->where('bookings.status', 'menunggu')
            ->orderByDesc('bookings.id')
            ->get();

        // daftar buku yang masih punya salinan tersedia
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

        $peminjam = DB::table('peminjams')->find($peminjamId);
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

    public function riwayat()
    {
        $peminjamId = session('peminjam_id');
        if (!$peminjamId) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        $pinjaman = DB::table('pinjams')
            ->join('salinan_bukus', 'pinjams.id_salinan', '=', 'salinan_bukus.id')
            ->join('bukus', 'salinan_bukus.id_buku', '=', 'bukus.id')
            ->where('pinjams.id_peminjam', $peminjamId)
            ->select(
                'pinjams.*',
                'salinan_bukus.kode_salinan',
                'bukus.judul'
            )
            ->orderByDesc('tanggal_pinjam')
            ->get();

        return view('pinjam.riwayat', compact('pinjaman'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $peminjamId = session('peminjam_id');

        // hanya boleh memproses pinjam miliknya & status masih aktif
        $pinjam = DB::table('pinjams')
            ->where('id', $id)
            ->where('id_peminjam', $peminjamId)
            ->whereNull('tanggal_kembali')
            ->first();

        if (!$pinjam) {
            return redirect()->route('pinjam.riwayat')
                ->with('error', 'Data peminjaman tidak valid.');
        }

        DB::beginTransaction();
        try {
            DB::statement("CALL spProsesPengembalian(?, ?)", [$id, Carbon::now()]);

            $damageFee = (int) $request->input('denda_kerusakan', 0);
            if ($damageFee > 0) {
                DB::table('pinjams')->where('id', $id)
                ->increment('denda_kerusakan', $damageFee);

                DB::table('peminjams')->where('id', $peminjamId)
                ->decrement('deposit', $damageFee);
            }

            DB::commit();
            return redirect()->route('pinjam.riwayat')
                ->with('success', 'Pengembalian berhasil diproses.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: '.$e->getMessage());
        }
    }


    public function kembalikan($id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status !== 'dipinjam' && $pinjam->status !== 'terlambat') {
            return redirect()->back()->with('info', 'Buku sudah dikembalikan.');
        }

        $pinjam->tanggal_kembali = Carbon::now();

        if (Carbon::parse($pinjam->tanggal_kembali)->gt(Carbon::parse($pinjam->tanggal_jatuh_tempo))) {
            $pinjam->status = 'terlambat';
        } else {
            $pinjam->status = 'dikembalikan';
        }

        $pinjam->save();

        $pinjam->salinan->update(['status' => 'tersedia']);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function salinan()
    {
        return $this->belongsTo(SalinanBuku::class, 'id_salinan');
    }
}
