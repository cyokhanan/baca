<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peminjam')->constrained('peminjams')->onDelete('cascade');
            $table->foreignId('id_salinan')->constrained('salinan_bukus')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();
            $table->decimal('denda_kerusakan', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjams');
    }
};
