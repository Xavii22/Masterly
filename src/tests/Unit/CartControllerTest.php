<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\CartController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCart()
    {
        $request = new Request();

        $cartController = new CartController();
        $response = $cartController->cart($request);

        $this->assertEquals('pages.cart', $response->name()); // Check returned view name
        $this->assertEquals($request, $response->getData()['request']); // Check returned request data
    }

    public function testQueryProductsAuthenticated()
    {
        Auth::shouldReceive('check')->once()->andReturn(true);

        $cartMock = Mockery::mock(Cart::class);
        $cartMock->shouldReceive('getCartProducts')->once()->andReturn(['product1', 'product2']);
        $this->app->instance(Cart::class, $cartMock);

        $request = new Request();

        $cartController = new CartController();
        $response = $cartController->queryProducts($request);

        $this->assertEquals(['product1', 'product2'], $response->getData()); // Check returned products
    }

    public function testQueryProductsGuest()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $request = new Request(['productIds' => [1, 2, 3]]);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('whereIn')->with('id', [1, 2, 3])->once()->andReturn(['product1', 'product2', 'product3']);
        $this->app->instance(Product::class, $productMock);

        $cartController = new CartController();
        $response = $cartController->queryProducts($request);

        $this->assertEquals(['product1', 'product2', 'product3'], $response->getData()); // Check returned products
    }

    // Additional test cases can be added for edge cases, validation, etc.
}
