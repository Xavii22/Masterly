<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySeeder extends Seeder
{

    public $categoryCounter = 0;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->delete();

        $data = file_get_contents(__DIR__ . '/../../database/products/products.json');
        $data = json_decode($data, true);

        foreach ($data['categories'] as $categoryData) {
            $category = new Category();
            $category->name = $categoryData['name'];
            $category->type = 'P';
            $category->save();

            foreach ($categoryData['subcategories'] as $subcategoryData) {
                $subcategory = new Category();
                $subcategory->name = $subcategoryData['name'];
                $subcategory->type = 'C';
                $subcategory->parent_id = $category->id;
                $subcategory->save();
            }
        }
    }
}
