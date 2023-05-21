<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\HeaderController;
use App\Models\Chat;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class HeaderControllerTest extends TestCase
{
    // public function testCheckUnreadChats()
    // {
    //     $buyerId = 1;
    //     $sellerId = 2;

    //     // Create buyer and seller orders with unread chats
    //     $buyerOrder = Order::factory()->create(['buyer_id' => $buyerId]);
    //     $sellerOrder = Order::factory()->create(['seller_id' => $sellerId]);

    //     // Create unread chats for the buyer order
    //     Chat::factory()->create([
    //         'order_id' => $buyerOrder->id,
    //         'type' => 'S',
    //         'read' => false,
    //     ]);
    //     Chat::factory()->create([
    //         'order_id' => $buyerOrder->id,
    //         'type' => 'B',
    //         'read' => true, // Read chat (shouldn't be counted)
    //     ]);

    //     // Create unread chats for the seller order
    //     Chat::factory()->create([
    //         'order_id' => $sellerOrder->id,
    //         'type' => 'B',
    //         'read' => false,
    //     ]);
    //     Chat::factory()->create([
    //         'order_id' => $sellerOrder->id,
    //         'type' => 'S',
    //         'read' => true, // Read chat (shouldn't be counted)
    //     ]);

    //     // Authenticate as the buyer
    //     Auth::shouldReceive('id')->andReturn($buyerId);

    //     $headerController = new HeaderController();
    //     $notificationCounter = $headerController->checkUnreadChats();

    //     $this->assertEquals(2, $notificationCounter); // Both buyer and seller unread chats should be counted
    // }
}
