<?php
// database/migrations/2024_02_01_000001_create_pendaftaran_tari_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_tari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('tarian_id')
                  ->constrained('tarian')
                  ->onDelete('cascade');
            $table->foreignId('jadwal_id')
                  ->constrained('jadwal_latihan')
                  ->onDelete('cascade');
            $table->enum('status', ['aktif', 'nonaktif', 'selesai'])->default('aktif');
            $table->date('tanggal_daftar');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu user tidak bisa daftar tarian+jadwal yang sama 2x
            $table->unique(['user_id', 'tarian_id', 'jadwal_id'], 'pendaftaran_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_tari');
    }
};