<?php
// database/migrations/2024_02_01_000002_create_kehadiran_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('jadwal_id')
                  ->constrained('jadwal_latihan')
                  ->onDelete('cascade');
            $table->foreignId('tarian_id')
                  ->constrained('tarian')
                  ->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'alpa'])->default('alpa');
            $table->text('keterangan')->nullable();
            $table->string('dicatat_oleh')->nullable();
            $table->timestamps();

            // Satu user hanya bisa punya 1 record per jadwal+tarian+tanggal
            $table->unique(['user_id', 'jadwal_id', 'tarian_id', 'tanggal'], 'kehadiran_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};