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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// buku
Route::resource('buku', BukuController::class);
Route::resource('penulis', PenulisController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('tim-penulis', TimPenulisController::class);
Route::resource('salinan-buku', SalinanBukuController::class);

// topup
Route::resource('peminjam', PeminjamController::class);
Route::resource('topup', TopupController::class);

// peminjaman
Route::resource('pinjam', PinjamController::class);
Route::resource('kerusakan', KerusakanController::class);

// booking
Route::resource('booking', BookingController::class);
Route::resource('daftar-tunggu', DaftarTungguController::class);

// halaman daftar + aksi SP
Route::get('pinjam', [PinjamController::class, 'index'])->name('pinjam.index');
Route::post('pinjam', [PinjamController::class, 'prosesPeminjaman'])->name('pinjam.store');
Route::get('/pinjam/pengembalian/{id}',      [PinjamController::class, 'prosesPengembalian'])->name('pinjam.kembali');
Route::get('/pinjam/booking-ke-pinjam/{id}', [PinjamController::class, 'bookingKePinjam'])->name('pinjam.bookingke');
Route::post('/pinjam/proses-peminjaman',      [PinjamController::class, 'prosesPeminjaman'])->name('pinjam.proses');

// auth
Route::get('/login'   , [AuthController::class,'showLogin'   ])->name('login');
Route::post('/login'   , [AuthController::class,'login'       ])->name('login.post');
Route::get ('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'    ])->name('register.post');
Route::post('/logout'  , [AuthController::class,'logout'      ])->name('logout');

// middleware cek login peminjam
Route::middleware('ceklogin')->group(function () {
    Route::post('/pinjam', [PinjamController::class, 'store'])->name('pinjam.store');
});
