<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HeaderController extends Controller
{
    public function checkUnreadChats()
    {
        $buyerOrderList = Order::where('buyer_id', Auth::id())->get();
        $sellerOrderList = Order::where('buyer_id', Auth::id())->get();

        $notificationCounter = 0;

        foreach ($buyerOrderList as $order) {
            foreach ($order->chats as $message) {
                if ($message->read == false && $message->type == 'S') {
                    $notificationCounter++;
                }
            }
        }

        foreach ($sellerOrderList as $order) {
            foreach ($order->chats as $message) {
                if ($message->read == false && $message->type == 'B') {
                    $notificationCounter++;
                }
            }
        }

        return $notificationCounter;
    }

    public function checkSpecificUnreadChat()
    {

        return '5';
    }

    public function header()
    {
        return view('pages.product');
    }
}
