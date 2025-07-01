<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Coffee',
                'slug' => 'coffee',
                'description' => 'Berbagai macam kopi'
            ],
            [
                'name' => 'Tea',
                'slug' => 'tea',
                'description' => 'Berbagai macam teh'
            ],
            [
                'name' => 'Wedang',
                'slug' => 'wedang',
                'description' => 'Minuman tradisional'
            ],
            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Makanan dan snack'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
