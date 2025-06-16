<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::with(['kategori','penulis','salinanTersedia'])->get();
        return view('dashboard.index', compact('bukus'));
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

        return view('pinjam.create', compact('buku', 'salinan'));
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
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        //
    }
}
