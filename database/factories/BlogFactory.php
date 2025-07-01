<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => fake()->realText(50),
            'description' => fake()->realText(300)
        ];
    }
}
