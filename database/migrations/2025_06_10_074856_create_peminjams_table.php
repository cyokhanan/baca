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
            $table->string('email', 100)->unique();
            $table->string('telepon', 20);
            $table->text('alamat');
            $table->string('password', 255);
            $table->decimal('deposit', 10, 2)->default(0);
            $table->boolean('status_blacklist')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
