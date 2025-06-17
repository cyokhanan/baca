<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idPeminjam = session('peminjam_id');
        $riwayat = DB::table('topups')->where('id_peminjam', $idPeminjam)->orderByDesc('tanggal')->get();

        return view('deposit.index', compact('riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000'
        ]);

        $id = session('peminjam_id');
        $jumlah = $request->jumlah;

        try {
            DB::statement("CALL spTambahDeposit(?, ?)", [$id, $jumlah]);
            return redirect()->route('deposit.index')->with('success', 'Deposit berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan deposit: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
