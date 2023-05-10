<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;
use GuzzleHttp\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    private function getInitialProductList()
    {
        $data = file_get_contents(base_path() . '/database/products/products.json');
        $data = json_decode($data, true);

        $category = $data['categories'][fake()->numberBetween(0, 2)];
        $subcategory = $category['subcategories'][fake()->numberBetween(0, count($category['subcategories']) - 1)];
        return $subcategory['products'][fake()->numberBetween(0, count($subcategory['products']) - 1)];
    }

    private function getStoreListAmount()
    {
        return fake()->numberBetween(1, count(Store::all()));
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = $this->getInitialProductList();

        return [
            'name' => $product['name'],
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(10, 100),
            'image' => $product['image'],
            'store_id' => $this->getStoreListAmount()
        ];
    }
    
}

Product::factory()->afterCreating(function (Product $product) {
    $client = new Client();

    $client->post('http://localhost:8080/api/store', [
        'json' => [
            'name' => $product->name,
            'path' => $product->image,
            'main' => false,
            'product_id' => $product->id
        ]
    ]);

})->count(10)->create();
