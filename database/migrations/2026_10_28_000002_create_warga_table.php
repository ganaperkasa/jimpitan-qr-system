<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('kode_warga', 20)->unique();
            $table->string('nama');
            $table->string('no_rumah', 20)->index();
            $table->string('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('status', 10)->default('aktif')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
