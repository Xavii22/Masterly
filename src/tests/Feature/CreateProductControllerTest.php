<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateProductControllerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test the creator method of the CreateProductController.
     *
     * @return void
     */
    public function testCreator()
    {
        // Get all the subcategories
        $categories = Category::where('type', 'C')->get();

        // Call the create method
        $response = $this->get(route('pages.createProduct'));

        // Assert the response
        $response->assertViewIs('pages.createProduct');
        $response->assertViewHas('subcategories', $categories);
    }

    /**
     * Test the createProduct method of the CreateProductController.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        // Create a store
        $store = Store::factory()->create();

        // Authenticate as the store owner
        Auth::loginUsingId($store->user_id);

        // Mock the file upload
        Storage::fake('images');
        $image = UploadedFile::fake()->image('product.jpg');

        // Create some categories
        $categories = Category::factory()->count(3)->create(['type' => 'C']);

        // Call the createProduct method
        $response = $this->post(route('createProduct'), [
            'name' => 'New Product',
            'description' => 'Product Description',
            'price' => 9.99,
            'enabled' => 'on',
            'important' => 'on',
            'subcategory' => $categories->first()->name,
            'image' => [$image],
        ]);

        // Assert the response
        $response->assertRedirect(route('pages.manageStore', ['id' => strtolower(str_replace(' ', '-', $store->name))]));

        // Assert the product was created
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'description' => 'Product Description',
            'price' => 9.99,
            'store_id' => $store->id,
            'enabled' => true,
            'important' => true,
        ]);

        // Assert the product has the correct category
        $product = Product::where('name', 'New Product')->first();
        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $categories->first()->id,
        ]);

        // Assert the product image was uploaded
        Storage::disk('images')->assertExists('product.jpg');
    }
}
