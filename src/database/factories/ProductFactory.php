<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    public function getDataFromUnsplashApi() {
        $description = null;

        while($description == null || $description > 30) {
            $client = new Client();
            $response = $client->get('https://api.unsplash.com/photos/random?client_id=T1QPdcgkjhmCWibl_FZfkj4JhrmmK6qwNdrLHEShMGc&query=product');
            $json = (string) $response->getBody();
            $data = json_decode($json, true);
            $description = $data['description'];
        }

        $image = $data['urls']['regular'];
        $productData = array($description, $image);

        return $productData;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productData = $this->getDataFromUnsplashApi();

        return [
            'name' => $productData[0],
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(10, 100),
            'category' => fake()->word(),
            'image' => $productData[1]
        ];
    }
}
