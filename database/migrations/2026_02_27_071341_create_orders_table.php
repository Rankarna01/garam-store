<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Contoh: INV-20260227-001
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->decimal('total_price', 12, 2);
            // Status pesanan
            $table->enum('status', ['pending', 'paid', 'processed', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->string('snap_token')->nullable(); // Untuk Midtrans nanti
            $table->string('tracking_number')->nullable(); // Nomor Resi
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};