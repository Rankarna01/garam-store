<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan 'owner' ke dalam daftar ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'customer', 'owner') NOT NULL DEFAULT 'customer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke semula jika di-rollback
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer'");
    }
};