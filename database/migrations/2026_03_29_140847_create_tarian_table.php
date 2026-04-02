<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tarian', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('asal');
            $table->enum('kategori', ['sakral','hiburan','penyambutan','ritual','perang'])->default('hiburan');
            $table->text('deskripsi');
            $table->string('fungsi')->nullable();
            $table->string('kostum')->nullable();
            $table->string('durasi')->nullable();         // "15–30 menit"
            $table->string('foto')->nullable();
            $table->string('video_url')->nullable();      // YouTube embed URL
            $table->boolean('unggulan')->default(false);
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tarian'); }
};