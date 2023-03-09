<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Category;
use app\Models\Product;
use app\Models\Categor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryProductFactory extends Factory
{

    public function forProduct(Product $product)
    {
        return $this->state([
            'product_id' => $product->id,
        ]);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return $this->afterCreating(function (CategoryProduct $categoryProduct) {
            $user = User::find($roleUser->user_id);
            $role = Role::find($roleUser->role_id);
            $user->roles()->attach($role);
        });
    }
}
