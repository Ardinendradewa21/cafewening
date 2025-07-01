<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void

    {
        Schema::disableForeignKeyConstraints();
        TransactionDetail::truncate();
        Transaction::truncate();
        Product::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        // Panggil seeder produk Anda yang sudah ada

        $this->call([
            ProductSeeder::class,
            UserSeeder::class,
        ]);
    }
}