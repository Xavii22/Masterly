<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $store = Store::factory()->create(['name' => 'testStore', 'user_id' => $user->id]);

        // Create a product
        $product = Product::factory()->create(['store_id' => $store->id]);

        // Make a POST request to edit product details
        $response = $this->actingAs($user)->post(route('pages.manageEditProductForms', ['id' => $product->id, 'form' => 'productDetails']), [
            'name' => 'New Product Name',
            'description' => 'Updated product description',
            'price' => 10,
        ]);        
        
        $product->save();

        // Assert that the product details are updated
        $this->assertEquals('New Product Name', $product->fresh()->name);
        $this->assertEquals('Updated product description', $product->fresh()->description);
        $this->assertEquals(10, $product->fresh()->price);
    }
}
