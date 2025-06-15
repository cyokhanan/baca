<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salinan_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_buku')->constrained('bukus')->onDelete('cascade');
            $table->string('kode_salinan', 10)->unique();
            $table->enum('status', ['tersedia','dipinjam','dibooking'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salinan_bukus');
    }
};
