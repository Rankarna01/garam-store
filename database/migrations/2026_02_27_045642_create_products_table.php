<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // Untuk URL ramah SEO (misal: garam-meja-halus)
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2); // Harga jual
            $table->decimal('original_price', 12, 2)->nullable(); // Harga coret (diskon)
            $table->integer('weight')->default(0); // Berat dalam gram (penting untuk ongkir nanti)
            $table->integer('stock')->default(0); // Sisa stok
            $table->string('image')->nullable(); // Path foto produk
            $table->boolean('is_active')->default(true); // Status tampil di web atau tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};