<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    private function checkIfUserIsNotLoggedIn()
    {
        if (!Auth::check()) {
            Log::error('The user needs to be logged in order to make an order.');
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
                Log::error('The product the user is trying to buy is already sold.');
                return redirect()->route('pages.home');
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

    private function setProductStateToSold($product)
    {
        $product->enabled = false;
        $product->sold = true;
        $product->save();
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
                $this->setProductStateToSold($orderProduct);                
            }

            ChatController::createMessage(env('INTRODUCTION_MESSAGE'), 'S', $order->id);
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

        return redirect()->route('pages.home');
    }
}
