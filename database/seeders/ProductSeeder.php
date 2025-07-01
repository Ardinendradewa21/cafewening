<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // <== PENTING: Impor model Product kita

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product::truncate();
        // Ini adalah data produk yang sebelumnya ada di file JavaScript Anda.
        $products = [
            ['name' => 'Kopi', 'price' => 10000, 'stock' => 100, 'icon' => '☕', 'category' => 'coffee'],
            ['name' => 'Cappuccino', 'price' => 12000, 'stock' => 100, 'icon' => '☕', 'category' => 'coffee'],
            ['name' => 'Kopi Susu', 'price' => 10000, 'stock' => 100, 'icon' => '🥛', 'category' => 'coffee'],
            ['name' => 'Es Teh', 'price' => 3000, 'icon' => '🧊', 'category' => 'tea'],
            ['name' => 'Teh Susu', 'price' => 11000, 'stock' => 100, 'icon' => '🥛', 'category' => 'tea'],
            ['name' => 'Lemon Tea', 'price' => 12000, 'stock' => 100, 'icon' => '🍋', 'category' => 'tea'],
            ['name' => 'Wedang Uwuh', 'price' => 7000, 'stock' => 100, 'icon' => '🌿', 'category' => 'wedang'],
            ['name' => 'Wedang Jahe', 'price' => 8000, 'stock' => 100, 'icon' => '🌿', 'category' => 'wedang'],
            ['name' => 'Bumbu Rujak Jowo', 'price' => 15000, 'stock' => 0, 'icon' => '🥗', 'category' => 'food'],
            ['name' => 'Mangut', 'price' => 14000, 'stock' => 0, 'icon' => '🍲', 'category' => 'pastry'],
            ['name' => 'Jangan Jowo', 'price' => 13000, 'stock' => 100, 'icon' => '🥬', 'category' => 'dessert'],
            ['name' => 'Gedang Goreng', 'price' => 7000, 'stock' => 100, 'icon' => '🍌', 'category' => 'dessert'],
            ['name' => 'Sompil', 'price' => 7000, 'stock' => 100, 'icon' => '🥞', 'category' => 'dessert'],
            ['name' => 'Tape Bakar', 'price' => 6000, 'stock' => 100, 'icon' => '🔥', 'category' => 'dessert'],
            ['name' => 'Tempe Jaket', 'price' => 6000, 'stock' => 100, 'icon' => '🥖', 'category' => 'dessert'],
        ];

        // Looping (perulangan) untuk setiap produk dalam array di atas
        foreach ($products as $product) {
            // Menggunakan model Product untuk membuat data baru di tabel 'products'
            Product::create($product);
        }
    }
}