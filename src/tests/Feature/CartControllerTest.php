<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class CartControllerTest extends TestCase
{

    /** @test */
    public function it_can_display_cart_page()
    {
        $response = $this->get('/cart');

        $response->assertViewIs('pages.cart');
    }

    /** @test */
    // public function it_can_query_products_from_cart_when_authenticated()
    // {
    //     $this->actingAs($user = User::factory()->create());
    //     $cart = Cart::factory()->create(['user_id' => $user->id]);
    //     $products = Product::factory(3)->create();

    //     $cart->products()->attach($products);

    //     $response = $this->post('/query-products');

    //     $response->assertJson($products->toArray());
    // }

    // /** @test */
    // public function it_can_query_products_from_cart_when_not_authenticated()
    // {
    //     $products = Product::factory(3)->create();

    //     $response = $this->post('/query-products', ['products' => $products->pluck('id')->toArray()]);

    //     $response->assertJson($products->toArray());
    // }
}
