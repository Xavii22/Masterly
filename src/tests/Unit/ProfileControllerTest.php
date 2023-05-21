<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testCheckSpecificUnreadChatWithBuyer()
    {
        $orderId = 1;
        $actor = 'buyer_id';

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();
        $mockOrder->shouldReceive('chats->get')->once()->andReturn(collect([]));

        $profileController = new ProfileController();
        $result = $profileController->checkSpecificUnreadChat($orderId, $actor);

        $this->assertEquals(0, $result);
    }

    public function testCheckSpecificUnreadChatWithSeller()
    {
        $orderId = 1;
        $actor = 'seller_id';

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();
        $mockOrder->shouldReceive('chats->get')->once()->andReturn(collect([]));

        $profileController = new ProfileController();
        $result = $profileController->checkSpecificUnreadChat($orderId, $actor);

        $this->assertEquals(0, $result);
    }

    public function testGetOrderHistoryWithBuyer()
    {
        $actor = 'buyer_id';

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('where')->once()->with($actor, Auth::id())->andReturnSelf();
        $mockOrder->shouldReceive('get->groupBy')->once()->with('number')->andReturn(collect([]));

        $profileController = new ProfileController();
        $result = $profileController->getOrderHistory($actor);

        $this->assertEquals([], $result);
    }

    public function testGetOrderHistoryWithSeller()
    {
        $actor = 'seller_id';

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('where')->once()->with($actor, Auth::id())->andReturnSelf();
        $mockOrder->shouldReceive('get->groupBy')->once()->with('number')->andReturn(collect([]));

        $profileController = new ProfileController();
        $result = $profileController->getOrderHistory($actor);

        $this->assertEquals([], $result);
    }

    public function testGetPendingOrders()
    {
        $orders = [
            [
                1 => [
                    [true],
                ],
            ],
            [
                2 => [
                    [false],
                ],
            ],
            [
                3 => [
                    [true],
                ],
            ],
        ];

        $profileController = new ProfileController();
        $result = $profileController->getPendingOrders($orders);

        $this->assertEquals([
            [
                2 => [
                    [false],
                ],
            ],
        ], $result);
    }

    public function testAcceptOrder()
    {
        $orderId = 1;

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();
        $mockOrder->shouldReceive('save')->once();

        $mockChatController = $this->mock('overload:App\Http\Controllers\ChatController');
        $mockChatController->shouldReceive('createMessage')->once()->with(env('CONFIRM_MESSAGE'), 'S', $orderId);

        $profileController = new ProfileController();
        $profileController->acceptOrder($orderId);
    }

    public function testDenyOrder()
    {
        $orderId = 1;

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();

        $mockProducts = $this->mock('overload:Illuminate\Database\Eloquent\Relations\BelongsToMany');
        $mockProducts->shouldReceive('get')->once()->andReturn(collect([]));

        $mockProduct = $this->mock('overload:App\Models\Product');
        $mockProduct->shouldReceive('save')->times(0);
        $mockProduct->shouldReceive('detach')->once();

        $mockChats = $this->mock('overload:Illuminate\Database\Eloquent\Relations\HasMany');
        $mockChats->shouldReceive('delete')->once();

        $mockOrder->shouldReceive('delete')->once();

        $profileController = new ProfileController();
        $profileController->denyOrder($orderId);
    }
}
