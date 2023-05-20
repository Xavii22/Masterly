<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ChatController;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;


class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateMessage()
    {
        $message = 'Test message';
        $type = 'info';
        $orderId = 1;

        ChatController::createMessage($message, $type, $orderId);

        $chat = Chat::latest()->first();

        $this->assertEquals($message, $chat->message);
        $this->assertEquals($type, $chat->type);
        $this->assertEquals($orderId, $chat->order_id);
    }

    public function testGetMessageValues()
    {
        $message = 'Test message';
        $type = 'info';
        $orderId = 1;

        $request = Request::create('/path', 'POST', [
            'message' => $message,
            'type' => $type,
            'orderId' => $orderId,
        ]);

        $chatController = new ChatController();
        $response = $chatController->getMessageValues($request);

        $this->assertEquals(302, $response->getStatusCode()); // Check redirect status code
        $this->assertEquals('pages.chat', $response->getTargetUrl()); // Check redirect route
    }
}
