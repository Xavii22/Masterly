<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; 
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_product')->delete();
        $productList = Product::all();
        $categoryList = Category::where('type', 'C')->get();

        foreach ($productList as $product) {
            $product->categories()->attach($categoryList->random());
        }
    }
}
