<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testOrderMethodWhenUserIsNotLoggedIn()
    {
        $response = $this->get('/order');
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }

    public function testOrderMethodWhenCartHasSoldProducts()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['sold' => true]);

        $this->actingAs($user);

        $response = $this->post('/order');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/home');
    }

    public function testOrderMethodWhenUserOwnsProduct()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $store = Store::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create(['store_id' => $store->id]);

        $this->actingAs($user);

        $response = $this->post('/order');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/home');
    }

    public function testOrderMethodWhenCartIsValid()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $store = Store::factory()->create(['user_id' => 999]); // Different user ID
        $product = Product::factory()->create(['store_id' => $store->id]);
        $orderNumber = Order::count() + 1;

        $this->actingAs($user);

        $response = $this->post('/order');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/home');

        $this->assertDatabaseHas('orders', [
            'number' => $orderNumber,
            'buyer_id' => $user->id,
            'seller_id' => $store->user_id,
        ]);

        $this->assertDatabaseHas('order_product', [
            'order_id' => Order::where('number', $orderNumber)->first()->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'enabled' => false,
            'sold' => true,
        ]);

        $this->assertDatabaseMissing('cart_product', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);
    }

    // Add more test cases for other methods in the OrderController

    // ...

    protected function setUp(): void
    {
        parent::setUp();

        // Perform any additional setup required for the tests
    }
}
