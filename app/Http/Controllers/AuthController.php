<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()    { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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

    public function login(Request $r)
    {
        $email    = $r->email;
        $password = $r->password;

        $user = collect(DB::select('CALL spGetPeminjamByEmail(?)', [$email]))->first();

        if ($user && Hash::check($password, $user->password)) {
            session([
                'peminjam_id'   => $user->id,
                'peminjam_nama' => $user->nama
            ]);
            return redirect()->route('buku.index');
        }
        return back()->withErrors(['login' => 'Email atau password salah.']);
    }

    public function register(Request $r)
    {
        $hashed = Hash::make($r->password);
        try {
            $row = collect(DB::select(
                'CALL spRegisterPeminjam(?,?,?,?,?)',
                [$r->nama, $r->email, $r->telepon, $r->alamat, $hashed]
            ))->first();

            session([
                'peminjam_id'   => $row->new_id,
                'peminjam_nama' => $r->nama
            ]);
            return redirect()->route('login.index');
        } catch (\Exception $e) {
            return back()->withErrors(['register' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
