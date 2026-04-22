<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('chats', function (Blueprint $table) {
        $table->id();
        $table->text('pesan_user'); // Menyimpan apa yang kamu tanya
        $table->text('jawaban_ai'); // Menyimpan apa yang dijawab Gemini
        $table->string('model_used')->default('gemini-2.5-flash'); // Catatan model mana yang dipakai
        $table->timestamps(); // Menyimpan kapan chat ini dibuat
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
