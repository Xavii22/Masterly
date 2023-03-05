<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->word(),
            'description'=>fake()->sentence(10),
            'price'=>fake()->randomFloat(1, 20, 90),
            'category'=>fake()->word(),
            'image'=>fake()->imageUrl(rand(480, 640), rand(480, 640), 'product')
        ];
    }
}
