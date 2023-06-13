<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartControllerTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_can_display_cart_page()
    {
        $response = $this->get('/cart');

        $response->assertViewIs('pages.cart');
    }

    // /** @test */
    // public function it_can_query_products_from_cart_when_not_authenticated()
    // {
    //     $products = Product::factory(3)->create();

    //     $productIds = $products->pluck('id')->toArray();

    //     $response = $this->post('/cart', ['products' => $productIds]);

    //     $response->assertJson($products->toArray());
    // }
}
