<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jimpitans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->date('tanggal')->index();
            $table->unsignedInteger('nominal');
            $table->string('catatan')->nullable();
            $table->string('status', 12)->default('tercatat')->index();
            // Token sekali pakai dari form: mencegah klik ganda tersimpan dua kali.
            // Satu warga tetap boleh punya banyak catatan per hari (token berbeda).
            $table->uuid('token')->nullable()->unique();
            $table->timestamps();

            $table->index(['warga_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jimpitans');
    }
};
