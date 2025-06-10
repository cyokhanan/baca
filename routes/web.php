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