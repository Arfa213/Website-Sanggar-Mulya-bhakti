<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sanggar_profile', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sanggar');
            $table->text('tagline')->nullable();
            $table->text('sejarah');
            $table->text('visi');
            $table->text('misi');           // JSON array of misi items
            $table->string('tahun_berdiri', 10)->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('foto_sejarah')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->integer('jumlah_penghargaan')->default(0);
            $table->integer('jumlah_event')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sanggar_profile'); }
};