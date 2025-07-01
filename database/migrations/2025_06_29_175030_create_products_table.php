<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Perintah Schema::create akan membuat tabel baru bernama 'products'
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' auto-increment (primary key)
            $table->string('name'); // Kolom untuk nama produk (VARCHAR)
            $table->integer('price'); // Kolom untuk harga produk (INTEGER)
            $table->string('category'); // Kolom untuk kategori (VARCHAR)
            $table->string('icon')->nullable(); // Kolom untuk icon (VARCHAR), nullable() berarti boleh kosong
            $table->timestamps(); // Membuat kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
