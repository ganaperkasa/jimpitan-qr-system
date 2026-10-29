<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rt', 50)->default('RT 01');
            $table->string('nama_rw', 50)->default('RW 01');
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            // Nominal tidak tetap: ini hanya saran awal di form dan tombol cepat.
            $table->unsignedInteger('nominal_default')->default(2000);
            $table->string('nominal_cepat')->default('1000,2000,5000,10000');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
