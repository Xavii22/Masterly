<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Tests\TestCase;
use Mockery;


class OrderControllerTest extends TestCase
{
    public function testOrderWithUserNotLoggedIn()
    {
        $mockAuth = $this->mock(Auth::class);
        $mockAuth->shouldReceive('check')->once()->andReturn(false);

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('error')->once()->with('The user needs to be logged in order to make an order.');

        $mockRedirect = $this->mock(Redirect::class);
        $mockRedirect->shouldReceive('route')->once()->with('pages.login')->andReturn('redirect response');

        $orderController = new OrderController();
        $result = $orderController->order();

        $this->assertEquals('redirect response', $result);
    }

    public function testOrderWithCartProductsSold()
    {
        $mockAuth = $this->mock(Auth::class);
        $mockAuth->shouldReceive('check')->once()->andReturn(true);
        $mockAuth->shouldReceive('id')->once()->andReturn(1);

        $mockProduct1 = $this->mock(Product::class);
        $mockProduct2 = $this->mock(Product::class);

        $mockProduct1->sold = false;
        $mockProduct2->sold = true;

        $mockCart = $this->mock(Cart::class);
        $mockCart->shouldReceive('where')->once()->with('user_id', 1)->andReturnSelf();
        $mockCart->shouldReceive('value')->once()->with('id')->andReturn(1);

        $mockProductList = collect([$mockProduct1, $mockProduct2]);
        $mockProduct = $this->mock(Product::class);
        $mockProduct->shouldReceive('getProductListFromSpecificCart')->once()->with(1)->andReturn($mockProductList);

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('error')->once()->with('The product the user is trying to buy is already sold.');

        $mockRedirect = $this->mock(Redirect::class);
        $mockRedirect->shouldReceive('route')->once()->with('pages.home')->andReturn('redirect response');

        $orderController = new OrderController();
        $result = $orderController->order();

        $this->assertEquals('redirect response', $result);
    }
}
