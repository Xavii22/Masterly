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
        $data = file_get_contents(__DIR__ . '/../../database/products/products.json');
        $data = json_decode($data, true);

        $category = $data['categories'][fake()->numberBetween(0, 2)];
        $subcategory = $category['subcategories'][fake()->numberBetween(0, count($category['subcategories'])-1)];
        $product = $subcategory['products'][fake()->numberBetween(0, count($subcategory['products'])-1)];

        return [
            'name' => $product['name'],
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(10, 100),
            'image' => $product['image']
        ];
    }
}
