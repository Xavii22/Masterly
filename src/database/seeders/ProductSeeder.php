<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use GuzzleHttp\Client;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete();
        Product::factory()->count(25)->afterCreating(function (Product $product) {
            $client = new Client([
                'verify' => false,
            ]);

            $data = file_get_contents(base_path() . '/database/products/images.json');
            $data = json_decode($data, true);


            foreach ($data['products'] as $item) {
                if ($item['name'] == $product->name) {
                    $images = $item['images'];
                }
            }

            $main = true;
            foreach ($images as $image) {
                $response = $client->post(env('API_URL') . '/api/store', [
                    'json' => [
                        'path' => $image,
                        'main' => $main,
                        'product_id' => $product->id
                    ]
                ]);
                $main = false;
            }
        })->create();
    }
}
