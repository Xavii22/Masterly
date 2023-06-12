<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;

class EditProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testEditProductDetails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        Auth::login($user);

        // Create a store for the user
        $store = Store::factory()->create(['user_id' => $user->id]);

        // Create a product
        $product = Product::factory()->create();

        // Make a POST request to edit product details
        $response = $this->post(route('edit-product-details', ['id' => $product->id]), [
            'name' => 'New Product Name',
            'description' => 'Updated product description',
            'price' => 9.99,
        ]);

        // Assert that the product details are updated
        $this->assertEquals('New Product Name', $product->fresh()->name);
        $this->assertEquals('Updated product description', $product->fresh()->description);
        $this->assertEquals(9.99, $product->fresh()->price);

        // Assert that the user is redirected to the store management page
        $response->assertRedirect(route('pages.manageStore', ['id' => $store->name]));
    }
}
