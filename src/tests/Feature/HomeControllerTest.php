<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Store;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{

    /** @test */
    public function it_can_display_home_page_with_default_parameters()
    {
        $response = $this->get('/home');

        $response->assertViewIs('pages.home');
        $response->assertViewHas('products');
    }

    // /** @test */
    // public function it_can_display_home_page_with_category_parameter()
    // {
    //     $category = Category::inRandomOrder()->first();

    //     $response = $this->get('&category=' . $category->id);

    //     $response->assertViewHas('category', $category->id);
    // }

    /** @test */
    public function it_can_display_product_details_page()
    {
        $product = Product::inRandomOrder()->first();

        $response = $this->get('/product/' . $product->id);

        $response->assertViewIs('pages.product');
        $response->assertViewHas('product');
    }

    // /** @test */
    // public function it_can_toggle_product_from_cart_when_authenticated()
    // {
    //     $this->actingAs($user = User::factory()->create());

    //     $product = Product::factory()->create();

    //     $response = $this->post('/toggle-cart', ['0' => $product->id]);

    //     $this->assertDatabaseHas('cart_product', [
    //         'cart_id' => $user->cart->id,
    //         'product_id' => $product->id,
    //     ]);
    // }

    // /** @test */
    // public function it_cannot_toggle_product_from_cart_when_not_authenticated()
    // {
    //     $product = Product::factory()->create();

    //     $response = $this->post('/toggle-cart', ['0' => $product->id]);

    //     $this->assertDatabaseMissing('cart_product', [
    //         'product_id' => $product->id,
    //     ]);
    // }

    // /** @test */
    // public function it_can_get_products_from_cart_when_authenticated()
    // {
    //     $this->actingAs($user = User::factory()->create());

    //     $response = $this->get('/get-cart-products');

    //     $response->assertJson($user->cart->products->pluck('id')->toArray());
    // }
}
