<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;

class OrderController extends Controller
{

    private function checkIfUserIsNotLoggedIn()
    {
        if (!Auth::check()) {
            return redirect()->route('pages.login');
        }
    }

    private function getCartProducts()
    {
        $cartId = Cart::where('user_id', Auth::id())->value('id');
        return Product::getProductListFromSpecificCart($cartId);
    }

    private function checkIfCartProductsAreSold($cartProducts)
    {
        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->sold == true) {
                dd('ESTE PRODUCTO YA ESTÁ VENDIDO!!');
            }
        }
    }

    private function getOrderNumber()
    {
        $orders = Order::all();

        if (count($orders) < 1) {
            return 1;
        }

        $lastOrder = Order::orderBy('updated_at', 'DESC')->first();
        return $lastOrder->number + 1;
    }

    private function createOrderRegisters($cartProducts)
    {
        $groupedProductsByStore = $cartProducts->groupBy('store_id');
        $orderNumber = $this->getOrderNumber();

        foreach ($groupedProductsByStore as $orderProducts) {
            $order = new Order();

            $order->number = $orderNumber;
            $order->buyer_id = Auth::id();
            $storeOwner = Store::find($orderProducts[0]['store_id']);
            $order->seller_id = User::find($storeOwner)->value('id');

            $order->save();

            foreach ($orderProducts as $orderProduct) {
                $order->products()->attach($orderProduct);
            }
        }
    }

    private function deleteProductsFromCart()
    {
        $userCart = Cart::where('user_id', Auth::id())->first();
        $userCart->products()->wherePivot('cart_id', $userCart->id)->detach();
    }

    public function order()
    {
        $redirectResponse = $this->checkIfUserIsNotLoggedIn();

        if ($redirectResponse) {
            return $redirectResponse;
        }

        $this->checkIfCartProductsAreSold($this->getCartProducts());
        $this->createOrderRegisters($this->getCartProducts());
        $this->deleteProductsFromCart();
    }
}
