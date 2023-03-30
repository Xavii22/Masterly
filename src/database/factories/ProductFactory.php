<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    public function getDataFromUnsplashApi()
    {
        $name = null;

        $client = new Client();
        $response = $client->get('https://api.unsplash.com/photos/random?client_id=T1QPdcgkjhmCWibl_FZfkj4JhrmmK6qwNdrLHEShMGc&query=product');
        $json = (string) $response->getBody();
        $data = json_decode($json, true);

        $name = $data['description'];
        $image = $data['urls']['regular'];

        if ($name >= 30 || $name == null) {
            $name = fake()->word();
        }

        $productData = array($name, $image);

        return $productData;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$productData = $this->getDataFromUnsplashApi();

        $data = file_get_contents(__DIR__ . '/../../database/products/products.json');
        $data = json_decode($data, true);

        $category = $data['categories'][fake()->numberBetween(0, 2)];
        $subcategory = $category['subcategories'][fake()->numberBetween(0, count($category)-1)];
        $product = $subcategory['products'][fake()->numberBetween(0, count($subcategory['products'])-1)];

        return [
            //'name' => $productData[0],
            'name' => $product['name'],
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(10, 100),
            //'image' => $productData[1]
            'image' => $product['image']
        ];
    }
}
