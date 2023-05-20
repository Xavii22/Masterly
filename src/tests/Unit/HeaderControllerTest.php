<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\HeaderController;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class HeaderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckUnreadChats()
    {
        $buyerOrder1 = Mockery::mock(Order::class);
        $buyerOrder1->chats = Mockery::mock();
        $buyerOrder1->chats->shouldReceive('getAttribute')->with('read')->andReturn(true, false, false);
        $buyerOrder2 = Mockery::mock(Order::class);
        $buyerOrder2->chats = Mockery::mock();
        $buyerOrder2->chats->shouldReceive('getAttribute')->with('read')->andReturn(true, true);
        $buyerOrder3 = Mockery::mock(Order::class);
        $buyerOrder3->chats = Mockery::mock();
        $buyerOrder3->chats->shouldReceive('getAttribute')->with('read')->andReturn(false, false);
        $buyerOrderList = [$buyerOrder1, $buyerOrder2, $buyerOrder3];

        $sellerOrder1 = Mockery::mock(Order::class);
        $sellerOrder1->chats = Mockery::mock();
        $sellerOrder1->chats->shouldReceive('getAttribute')->with('read')->andReturn(false, true, true);
        $sellerOrder2 = Mockery::mock(Order::class);
        $sellerOrder2->chats = Mockery::mock();
        $sellerOrder2->chats->shouldReceive('getAttribute')->with('read')->andReturn(true, true);
        $sellerOrder3 = Mockery::mock(Order::class);
        $sellerOrder3->chats = Mockery::mock();
        $sellerOrder3->chats->shouldReceive('getAttribute')->with('read')->andReturn(false, false);
        $sellerOrderList = [$sellerOrder1, $sellerOrder2, $sellerOrder3];

        Auth::shouldReceive('id')->andReturn(1);

        $orderMock = Mockery::mock(Order::class);
        $orderMock->shouldReceive('where')->with('buyer_id', 1)->once()->andReturnSelf();
        $orderMock->shouldReceive('get')->once()->andReturn($buyerOrderList);
        $orderMock->shouldReceive('where')->with('seller_id', 1)->once()->andReturnSelf();
        $orderMock->shouldReceive('get')->once()->andReturn($sellerOrderList);
        $this->app->instance(Order::class, $orderMock);

        $headerController = new HeaderController();
        $unreadChats = $headerController->checkUnreadChats();

        $this->assertEquals(4, $unreadChats); // Check the number of unread chats
    }

    public function testHeader()
    {
        $headerController = new HeaderController();
        $response = $headerController->header();

        $this->assertEquals('pages.product', $response->name()); // Check returned view name
    }

    // Additional test cases can be added for edge cases, different scenarios, etc.
}
