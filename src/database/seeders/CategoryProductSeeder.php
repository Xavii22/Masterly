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
        DB::table('category_product')
            ->whereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('type', '=', 'P')
                    ->orWhere('type', '=', 'C');
            })
            ->delete();

        $productList = Product::all();
        $data = file_get_contents(base_path() . '/database/products/products.json');
        $data = json_decode($data, true);

        foreach ($productList as $databaseProduct) {
            foreach ($data["categories"] as $category) {
                foreach ($category["subcategories"] as $subcategory) {
                    foreach ($subcategory["products"] as $productName) {
                        if ($productName["name"] == $databaseProduct->name) {
                            $categoryId = Category::where('name', $subcategory['name'])->firstOrFail();
                            $databaseProduct->categories()->attach($categoryId->id, [
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            continue;
                        }
                    }
                }
            }
        }
    }
}
