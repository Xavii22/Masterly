<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomeMethodWithQueryAndCategory()
    {
        $category = Category::factory()->create(['type' => 'P']);
        $product = Product::factory()->create();
        
        $response = $this->get('/home?query=test&category=' . $category->id);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        });
    }

    public function testHomeMethodWithoutQueryAndCategory()
    {
        $product = Product::factory()->create();
        
        $response = $this->get('/home');
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewHas('products', function ($products) use ($product) {
            return $products->contains($product);
        });
    }

    public function testShowProductDetailsWithValidId()
    {
        $product = Product::factory()->create();

        $response = $this->get('/product/' . $product->id);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewHas('product', $product);
    }

    public function testShowProductDetailsWithInvalidId()
    {
        $response = $this->get('/product/9999999');

        $response->assertSee('404');
    }
}
