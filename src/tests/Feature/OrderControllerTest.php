<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;


    public function test_order_user_not_logged_in()
    {
        // Make a GET request to the order endpoint without authentication
        $response = $this->get('/order');

        // Assert that the response is a redirect to the login page
        $response->assertRedirect(route('pages.login'));
    }

    public function test_order_user_owns_product()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a store and associate it with the user
        $store = Store::create([
            'name' => 'Your Store Name',
            'logo' => 'your-logo-path.png',
            'user_id' => $user->id,
        ]);

        // Create a product that belongs to the user's store
        $product = Product::factory()->create([
            'store_id' => $store->id,
        ]);

        // Add the product to the user's cart
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);
        $cart->products()->attach($product->id);

        // Make a POST request to the order endpoint
        $response = $this->post('/order');

        // Assert that the response is a redirect to the error page
        $response->assertRedirect(route('errors.defaultError'));
    }
}
