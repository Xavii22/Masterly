<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery;

class ProfileControllerTest extends TestCase
{
    public function testGetPendingOrders()
    {
        $orders = [
            1 => [
                0 => [
                    0 => [],
                    1 => true,
                    2 => 1,
                ],
            ],
            2 => [
                0 => [
                    0 => [],
                    1 => false,
                    2 => 2,
                ],
                1 => [
                    0 => [],
                    1 => true,
                    2 => 3,
                ],
            ],
        ];

        $profileController = new ProfileController();
        $result = $profileController->getPendingOrders($orders);

        $expectedResult = [
            2 => [
                0 => [
                    0 => [],
                    1 => false,
                    2 => 2,
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testAcceptOrder()
    {
        $orderId = 1;

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();
        $mockOrder->accepted = false;
        $mockOrder->shouldReceive('save')->once();

        $mockChatController = $this->mock(ChatController::class);
        $mockChatController->shouldReceive('createMessage')->once()->with(env('CONFIRM_MESSAGE'), 'S', $orderId);

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('info')->once()->with('The order with id: ' . $orderId, ' has been accepted.');

        $profileController = new ProfileController();
        $profileController->acceptOrder($orderId);
    }

    public function testDenyOrder()
    {
        $orderId = 1;

        $mockOrder = $this->mock(Order::class);
        $mockOrder->shouldReceive('find')->once()->with($orderId)->andReturnSelf();
        $mockOrder->accepted = false;
        $mockOrder->shouldReceive('delete')->once();

        $mockChatController = $this->mock(ChatController::class);
        $mockChatController->shouldReceive('createMessage')->once()->with(env('DENY_MESSAGE'), 'S', $orderId);

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('info')->once()->with('The order with id: ' . $orderId, ' has been denied and deleted.');

        $profileController = new ProfileController();
        $profileController->denyOrder($orderId);
    }

    public function testUpdateAvatar()
    {
        $request = $this->mock(Request::class);
        $request->shouldReceive('validate')->once()->andReturn([
            'avatar' => 'avatar.jpg',
        ]);

        $user = $this->mock(User::class);
        $user->shouldReceive('getAttribute')->once()->with('avatar')->andReturn('old_avatar.jpg');
        $user->shouldReceive('setAttribute')->once()->with('avatar', 'avatar.jpg');
        $user->shouldReceive('save')->once();

        $mockStorage = $this->mock(Storage::class);
        $mockStorage->shouldReceive('disk')->once()->with('public')->andReturnSelf();
        $mockStorage->shouldReceive('delete')->once()->with('old_avatar.jpg');

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('info')->once()->with('User avatar has been updated.');

        $profileController = new ProfileController();
        $profileController->updateAvatar($request);
    }
}
