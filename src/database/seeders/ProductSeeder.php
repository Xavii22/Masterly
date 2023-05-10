<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete();
        Product::factory(10)->create();

        // Product::factory(20)->afterCreating(function (Product $product) {
        //     $client = new Client();
        
        //     $client->post('http://localhost:8080/api/store', [
        //         'json' => [
        //             'name' => $product->name,
        //             'path' => $product->image,
        //             'main' => false,
        //             'product_id' => $product->id
        //         ]
        //     ]);
        
        // })->create();
    }
}
