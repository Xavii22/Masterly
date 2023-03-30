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
        $data = file_get_contents(__DIR__ . '/../../database/products/products.json');
        $data = json_decode($data, true);

        foreach ($productList as $databaseProduct) {
            foreach ($data["categories"] as $category) {
                foreach ($category["subcategories"] as $subcategory) {
                    foreach ($subcategory["products"] as $productName) {
                        if ($productName["name"] == $databaseProduct->name) {
                            $categoryId = Category::where('name', $subcategory['name'])->firstOrFail();
                            $databaseProduct->categories()->attach($categoryId->id);
                            continue;
                        }
                    }
                }
            }
        }
    }
}
