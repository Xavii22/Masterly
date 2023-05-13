<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public static function createMessage($message, $type, $orderId)
    {
        $chat = new Chat();

        $chat->message = $message;
        $chat->type = $type;
        $chat->order_id = $orderId;

        $chat->save();
    }

    public function getMessageValues(Request $request)
    {
        $this->createMessage($request->input('message'), $request->input('type'), $request->input('orderId'));

        $orderId = $request->input('orderId');
        $userType = $request->input('type');

        session(['orderId' => $orderId, 'userType' => $userType]);

        return redirect()->route('pages.chat');
    }

    private function getChatMessages($orderId)
    {
        return Chat::where('order_id', $orderId)->get();
    }

    public function enterChat(Request $request)
    {
        $orderId = $request->input('orderId');
        if ($orderId == null) {
            $orderId = session('orderId');
        }

        $chatMessages = $this->getChatMessages($orderId);

        $userType = $request->input('userType');
        if ($userType == null) {
            $userType = session('userType');
        }

        return view('pages.chat', compact('chatMessages', 'userType', 'orderId'));
    }
}
