<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;

class ChatControllerTest extends TestCase
{
    public function testCreateMessage()
    {
        $message = 'Test message';
        $type = 'S';
        $orderId = 1;

        $controller = new ChatController();
        $controller->createMessage($message, $type, $orderId);

        $this->assertDatabaseHas('chats', [
            'message' => $message,
            'type' => $type,
            'order_id' => $orderId,
        ]);
    }

    public function testGetMessageValues()
    {
        $message = 'Test message';
        $type = 'S';
        $orderId = 1;

        $request = Request::create('/path', 'POST', [
            'message' => $message,
            'type' => $type,
            'orderId' => $orderId,
        ]);
        
        $controller = new ChatController();
        $response = $controller->getMessageValues($request);

        $this->assertEquals($orderId, session('orderId'));
        $this->assertEquals($type, session('userType'));
    }
}
