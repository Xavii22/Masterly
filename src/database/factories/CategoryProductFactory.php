<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Category;
use app\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryProductFactory extends Factory
{

    public function getEveryCategoryProductRegister()
    {
        $productList = array(Product::all());
        $categoryList = array();
        for ($i=0; $i < count($productList); $i++) { 
            array_push($categoryList, );
        }

        return $categoryList;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return;
    }
}
