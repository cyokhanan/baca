<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_tunggus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_buku')->constrained('bukus')->onDelete('cascade');
            $table->foreignId('id_peminjam')->constrained('peminjams')->onDelete('cascade');
            $table->dateTime('tanggal_permintaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_tunggus');
    }
};
