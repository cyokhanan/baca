<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->unique();
            $table->string('telepon', 20);
            $table->text('alamat')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('password', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->decimal('deposit', 10, 2)->default(0);
            $table->boolean('status_blacklist')->default(false);
            $table->date('blacklist_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
