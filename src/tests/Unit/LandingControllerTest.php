<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LandingController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LandingControllerTest extends TestCase
{
    // public function testLanding()
    // {
    //     // Create active tags
    //     $activeTags = [
    //         [
    //             'id' => 1,
    //             'name' => 'Tag 1',
    //         ],
    //         [
    //             'id' => 2,
    //             'name' => 'Tag 2',
    //         ],
    //     ];
    //     $activeTagsJson = json_encode(['activeTags' => $activeTags]);
    //     file_put_contents(base_path() . env('ACTIVE_TAGS'), $activeTagsJson);

    //     // Create categories and associated products for each tag
    //     foreach ($activeTags as $activeTag) {
    //         $category = Category::factory()->create(['name' => $activeTag['name'], 'type' => 'T']);
    //         Product::factory()->count(3)->create()->each(function ($product) use ($category) {
    //             $product->categories()->attach($category->id);
    //         });
    //     }

    //     $landingController = new LandingController();
    //     $response = $landingController->landing();

    //     $tags = $response->getData()['tags'];

    //     $this->assertCount(2, $tags); // Assert there are 2 tags

    //     foreach ($tags as $tag) {
    //         $this->assertArrayHasKey('id', $tag);
    //         $this->assertArrayHasKey('name', $tag);
    //         $this->assertArrayHasKey('products', $tag);

    //         $categoryId = $tag['id'];
    //         $categoryName = $tag['name'];

    //         $this->assertEquals($categoryName, Category::where('id', $categoryId)->value('name')); // Assert category name is correct

    //         $products = $tag['products'];
    //         $this->assertCount(3, $products); // Assert each tag has 3 products
    //     }
    // }

    // public function tearDown(): void
    // {
    //     unlink(base_path() . env('ACTIVE_TAGS'));
    //     parent::tearDown();
    // }
}
