<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class OrderControllerTest extends TestCase
{
    /**
     * Test the order method of the OrderController.
     *
     * @return void
     */
    public function testOrder()
    {
        // Create a fake authenticated user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Mock the dependencies
        $cartMock = $this->mock(Cart::class);
        $cartMock->shouldReceive('where')->once()->with('user_id', $user->id)->andReturnSelf();
        $cartMock->shouldReceive('first')->once()->andReturnSelf();
        $cartMock->shouldReceive('products')->once()->andReturnSelf();
        $cartMock->shouldReceive('wherePivot')->once()->with('cart_id', 1)->andReturnSelf();
        $cartMock->shouldReceive('detach')->once();

        $productMock = $this->mock(Product::class);
        $productMock->shouldReceive('getProductListFromSpecificCart')->once()->with(1)->andReturn([]);

        $storeMock = $this->mock(Store::class);
        $storeMock->shouldReceive('where')->once()->with('user_id', $user->id)->andReturnSelf();
        $storeMock->shouldReceive('value')->once()->with('id')->andReturn(1);

        $orderMock = $this->mock(Order::class);
        $orderMock->shouldReceive('all')->once()->andReturn([]);
        $orderMock->shouldReceive('orderBy')->once()->with('updated_at', 'DESC')->andReturnSelf();
        $orderMock->shouldReceive('first')->once()->andReturn((object) ['number' => 1]);
        $orderMock->shouldReceive('attach')->once();
        $orderMock->shouldReceive('save')->once();

        $chatControllerMock = $this->mock(\App\Http\Controllers\ChatController::class);
        $chatControllerMock->shouldReceive('createMessage')->once();

        $logMock = $this->partialMock(Log::class);
        $logMock->shouldReceive('error')->twice();

        // Mock the Auth facade
        Auth::shouldReceive('check')->once()->andReturn(true);

        // Register routes to be able to test redirects
        Route::get('/login', fn () => 'Login')->name('pages.login');
        Route::get('/errors/default', fn () => 'Default Error')->name('errors.default');
        Route::get('/home', fn () => 'Home')->name('pages.home');

        // Send a GET request to the order endpoint
        $response = $this->get('/order');

        // Assert that the response is a redirect to the home route
        $response->assertRedirect('/home');
    }
}
