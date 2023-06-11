<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HeaderController extends Controller
{
    public function checkUnreadChats()
    {
        $buyerOrderList = Order::where('buyer_id', Auth::id())->get();
        $sellerOrderList = Order::where('seller_id', Auth::id())->get();

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

    public static function userCircle($username)
    {
        $colorCode = ord(strtoupper(substr($username, 0, 1)));
        $red = ($colorCode * 17) % 255;
        $green = ($colorCode * 13) % 255;
        $blue = ($colorCode * 19) % 255;
        $color = sprintf('#%02x%02x%02x', $red, $green, $blue);
        return '<div style="background-color:' . $color . '; display: flex; justify-content: center; align-items: center; border-radius: 100%; width: 35px; height: 35px; text-align: center; font-size: 18px; color: white; line-height: 50px;">' . strtoupper(substr($username, 0, 1)) . '</div>';
    }

    public function header()
    {
        return view('pages.product');
    }
}
