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

    /** @test */
    public function it_can_display_home_page_with_category_parameter()
    {
        $category = Category::inRandomOrder()->first();

        $response = $this->get('/home?category=' . $category->id);

        $response->assertViewIs('pages.home');
        $response->assertViewHas('category', $category->id);
    }

    /** @test */
    public function it_can_display_product_details_page()
    {
        $product = Product::inRandomOrder()->first();

        $response = $this->get('/product/' . $product->id);

        $response->assertViewIs('pages.product');
        $response->assertViewHas('product');
    }

    /** @test */
    public function it_cannot_toggle_product_from_cart_when_not_authenticated()
    {
        $product = Product::factory()->create();

        $this->post('/home', ['0' => $product->id]);

        $this->assertDatabaseMissing('cart_product', [
            'product_id' => $product->id,
        ]);
    }
}
