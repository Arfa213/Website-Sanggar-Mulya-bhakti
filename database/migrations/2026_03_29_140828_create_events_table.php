<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('lokasi');
            $table->date('tanggal');
            $table->enum('kategori', ['internasional','nasional','festival','pentas','kompetisi'])->default('pentas');
            $table->enum('level', ['Internasional','Nasional','Lokal'])->default('Lokal');
            $table->string('hasil')->nullable();          // 🥇 Juara 1, Silver Award, dll.
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->json('penghargaan')->nullable();      // ["Best Performance","Most Authentic Costume"]
            $table->integer('jumlah_penonton')->nullable();
            $table->boolean('unggulan')->default(false);
            $table->enum('status', ['akan_datang','selesai'])->default('akan_datang');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('events'); }
};