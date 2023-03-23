<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            // Other attributes
            'type' => $this->faker->randomElement(['P', 'C']),
        ];
    }

    // Define a state for creating P categories
    public function pCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'P',
            ];
        });
    }

    // Define a state for creating C categories
    public function cCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'C',
            ];
        });
    }
}