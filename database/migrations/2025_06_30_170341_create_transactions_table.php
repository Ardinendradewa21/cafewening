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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap transaksi
            $table->string('transaction_code')->unique(); // Kode unik, misal: TRX-20250701-001
            $table->bigInteger('total_amount'); // Total harga transaksi
            $table->timestamps(); // Waktu transaksi dibuat (created_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
