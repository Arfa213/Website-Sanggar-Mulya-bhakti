<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_latihan', function (Blueprint $table) {
            $table->id();
            $table->string('hari');           // Senin, Selasa, ...
            $table->string('jam_mulai', 10);  // 15:00
            $table->string('jam_selesai', 10);// 17:30
            $table->string('kelas');          // Tari Dasar (Pemula)
            $table->string('tempat');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('jadwal_latihan'); }
};