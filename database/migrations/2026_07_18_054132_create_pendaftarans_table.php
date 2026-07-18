<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('cascade');
            $table->enum('status', ['pending', 'dikonfirmasi', 'dibatalkan'])->default('pending');
            $table->string('nomor_pendaftaran')->unique();
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamps();

            // Satu user hanya bisa daftar satu kali per kegiatan
            $table->unique(['user_id', 'kegiatan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
