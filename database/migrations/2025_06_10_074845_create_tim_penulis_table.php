<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tim_penulis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_penulis');
            $table->primary(['id_buku','id_penulis']);
            $table->foreign('id_buku')->references('id')->on('bukus')->onDelete('cascade');
            $table->foreign('id_penulis')->references('id')->on('penulis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tim_penulis');
    }
};
