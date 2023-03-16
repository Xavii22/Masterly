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
            'name' => fake()->word(),
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(10, 100),
            'category' => fake()->word(),
            'image' => fake()->imageUrl(rand(480, 640), rand(480, 640), 'product')
            //'image' => ProductFactory::getRandomImage()
        ];
    }

    public function getRandomImage()
    {
        $access_key = 'T1QPdcgkjhmCWibl_FZfkj4JhrmmK6qwNdrLHEShMGc';
        $endpoint = 'https://api.unsplash.com/photos/random';

        $params = [
            'count' => 1
        ];

        $headers = [
            'Authorization: Client-ID ' . $access_key
        ];

        $url = $endpoint . '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cacert.pem'); // Set the path to the CA certificate bundle

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $data = json_decode($response, true);

            if (is_array($data) && !empty($data)) {
                $photo_url = $data[0]['urls']['regular'];

                echo '<img src="' . $photo_url . '" />';
            } else {
                echo 'Error: Invalid response from API';
            }
        }

        curl_close($ch);
    }
}
