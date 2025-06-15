<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->foreignId('id_kategori')->constrained('kategoris')->onDelete('cascade');
            $table->decimal('biaya_sewa', 10, 2);
            $table->unsignedTinyInteger('rating_bintang');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE bukus ADD CONSTRAINT chk_rating CHECK (rating_bintang BETWEEN 1 AND 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
