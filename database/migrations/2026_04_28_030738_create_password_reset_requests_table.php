<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('password_reset_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email'); // Email customer yang lupa sandi
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Status permintaan
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('password_reset_requests');
    }
};