<?php

namespace Tests\Feature\Controllers;

use App\Models\Chat;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    /** @test */
    public function it_can_create_message()
    {
        $chat = new Chat();

        $message = 'Test message';
        $type = 'B';
        $orderId = 1;

        $chat->message = $message;
        $chat->type = $type;
        $chat->order_id = $orderId;

        $chat->save();

        $this->assertDatabaseHas('chats', [
            'message' => $message,
            'type' => $type,
            'order_id' => $orderId,
        ]);
    }

    /** @test */
    // public function it_can_get_message_values_and_redirect_to_chat_page()
    // {
    //     $message = 'Test message';
    //     $type = 'test';
    //     $orderId = 1;

    //     $response = $this->post('/get-message-values', [
    //         'message' => $message,
    //         'type' => $type,
    //         'orderId' => $orderId,
    //     ]);

    //     $response->assertRedirect(route('pages.chat'));
    //     $response->assertSessionHas(['orderId' => $orderId, 'userType' => $type]);
    // }

    /** @test */
    // public function it_can_enter_chat_and_display_messages()
    // {
    //     $chatMessages = Chat::factory(3)->create();
    //     $orderId = $chatMessages->first()->order_id;
    //     $userType = 'test';

    //     $response = $this->get('/enter-chat', [
    //         'orderId' => $orderId,
    //         'userType' => $userType,
    //     ]);

    //     $response->assertViewIs('pages.chat');
    //     $response->assertViewHas('chatMessages', $chatMessages);
    //     $response->assertViewHas('userType', $userType);
    //     $response->assertViewHas('orderId', $orderId);
    // }
}
