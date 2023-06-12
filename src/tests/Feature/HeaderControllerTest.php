<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Chat;
use App\Models\User;
use App\Http\Controllers\HeaderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HeaderControllerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test the checkUnreadChats method of the HeaderController.
     *
     * @return void
     */
    public function testCheckUnreadChats()
    {
        // Create a user
        $user = User::factory()->create();

        // Create buyer order with unread chat
        $buyerOrder = Order::create(['number' => 1, 'buyer_id' => $user->id]);
        $buyerChat = Chat::create(['order_id' => $buyerOrder->id, 'read' => false, 'type' => 'S']);

        // Create seller order with unread chat
        $sellerOrder = Order::create(['number' => 2, 'seller_id' => $user->id]);
        $sellerChat = Chat::create(['order_id' => $sellerOrder->id, 'read' => false, 'type' => 'B']);

        // Create buyer order with read chat
        $buyerOrder2 = Order::create(['number' => 3, 'buyer_id' => $user->id]);
        $buyerChat2 = Chat::create(['order_id' => $buyerOrder2->id, 'read' => true, 'type' => 'S']);

        // Create seller order with read chat
        $sellerOrder2 = Order::create(['number' => 4, 'seller_id' => $user->id]);
        $sellerChat2 = Chat::create(['order_id' => $sellerOrder2->id, 'read' => true, 'type' => 'B']);

        // Authenticate the user
        Auth::login($user);

        // Call the checkUnreadChats method
        $result = HeaderController::checkUnreadChats();

        // Assert the result
        $this->assertEquals(2, $result);
    }

    /**
     * Test the header method of the HeaderController.
     *
     * @return void
     */
    public function testHeader()
    {
        // Authenticate the user
        $user = User::factory()->create();
        Auth::login($user);

        $product = User::factory()->create();
        // Call the header method
        $response = $this->get(route('pages.product', [$product->id]));

        // Assert the response
        $response->assertViewIs('pages.product');
    }
}
