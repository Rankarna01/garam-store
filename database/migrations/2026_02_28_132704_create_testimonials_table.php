<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pemberi ulasan
            $table->string('profession')->nullable(); // Contoh: "Chef Profesional", "Ibu Rumah Tangga"
            $table->text('message'); // Isi testimoni
            $table->integer('rating')->default(5); // Bintang 1-5
            $table->string('avatar')->nullable(); // Foto profil (opsional)
            $table->boolean('is_active')->default(true); // Status tampil di web
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('testimonials');
    }
};