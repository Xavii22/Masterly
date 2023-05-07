<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends Controller
{
    private function getOrderHistory()
    {
        $orders = Order::where('buyer_id', Auth::id())->get();

        return $orders;
    }

    public function profile()
    {
        $orders = $this->getOrderHistory();
        return view('pages.profile', compact('orders'));
    }
}
