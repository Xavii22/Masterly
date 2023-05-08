<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    private function getOrderHistory()
    {
        $orderProducts = array();
        $orders = Order::where('buyer_id', Auth::id())->get()->groupBy('number');

        foreach ($orders as $key => $order) {
            $orderProducts[$key][0] = $order[0]->created_at->format('d-m-Y');

            foreach ($order as $key2 => $vendorOrder) {
                $orderProducts[$key][1][$key2] = $vendorOrder->products()->wherePivot('order_id', $vendorOrder->id)->get();
            }

            if ($order[0]->accepted == true) {
                $orderProducts[$key][2] = true;
            } else {
                $orderProducts[$key][2] = false;
            }
        }

        return $orderProducts;
    }

    private function acceptOrder()
    {
        dd('ayoooooooooo');
    }

    public function profile()
    {
        $orders = $this->getOrderHistory();
        return view('pages.profile', compact('orders'));
    }
}
