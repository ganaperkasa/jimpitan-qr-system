<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jimpitan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jimpitan_id')->constrained('jimpitans')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('aksi', 20);
            $table->text('alasan')->nullable();
            $table->unsignedInteger('nominal_lama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jimpitan_logs');
    }
};
