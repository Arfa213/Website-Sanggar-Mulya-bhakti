<?php
// database/migrations/2024_02_01_000003_create_chatbot_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('chatbot_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');          // guest session ID
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('role', ['user', 'assistant']);
            $table->text('content');
            $table->timestamps();
            $table->index('session_id');
        });
    }
    public function down(): void { Schema::dropIfExists('chatbot_messages'); }
};      