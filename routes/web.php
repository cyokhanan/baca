<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\TimPenulisController;
use App\Http\Controllers\SalinanBukuController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DaftarTungguController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalian;

// Auth
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Peminjam
Route::middleware('ceklogin')->group(function () {
    Route::get('/dashboard', [BukuController::class, 'index'])->name('dashboard.index');

    Route::get('/akun', function () {
        $peminjam = \App\Models\Peminjam::find(session('peminjam_id'));
        return view('akun.index', compact('peminjam'));
    })->name('akun.index');

    Route::resource('buku', BukuController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('tim-penulis', TimPenulisController::class);
    Route::resource('salinan-buku', SalinanBukuController::class);
    Route::resource('peminjam', PeminjamController::class);
    Route::resource('topup', TopupController::class);

    Route::get('/pinjam', [PinjamController::class, 'index'])->name('pinjam.index');
    Route::get('/pinjam/create/{buku}', [PinjamController::class, 'create'])->name('pinjam.create');
    Route::post('/pinjam', [PinjamController::class, 'store'])->name('pinjam.store');
    Route::get('/riwayat', [PinjamController::class, 'riwayat'])->name('pinjam.riwayat');
    Route::post('/pinjam/kembali/{id}', [PinjamController::class, 'prosesPengembalian'])
        ->name('pinjam.kembali')
        ->middleware('ceklogin');

    Route::resource('kerusakan', KerusakanController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('daftar-tunggu', DaftarTungguController::class);

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');
});
