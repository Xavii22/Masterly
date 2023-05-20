<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function checkSpecificUnreadChat($orderId, $actor)
    {
        $messages = Order::find($orderId)->chats()->get();
        $notificationCounter = 0;

        if($actor == 'buyer_id') {
            $actor = 'B';
        } else {
            $actor = 'S';
        }
        
        foreach ($messages as $message) {
            if ($message->read == false && $message->type != $actor) {
                $notificationCounter++;
            }
        }

        return $notificationCounter;
    }

    private function getOrderHistory($actor)
    {
        $orderProducts = array();
        $orders = Order::where($actor, Auth::id())->get()->groupBy('number');

        foreach ($orders as $key => $order) {
            $orderProducts[$key][0] = $order[0]->created_at->format('d-m-Y');

            foreach ($order as $key2 => $vendorOrder) {
                $orderProducts[$key][1][$key2][0] = $vendorOrder->products()->wherePivot('order_id', $vendorOrder->id)->get();
                $orderProducts[$key][1][$key2][1] = $vendorOrder->accepted;
                $orderProducts[$key][1][$key2][2] = $vendorOrder->id;
                $orderProducts[$key][1][$key2][3] = Store::where('user_id', $vendorOrder->seller_id)->value('name');
                $orderProducts[$key][1][$key2][4] = $this->checkSpecificUnreadChat($vendorOrder->id, $actor);
            }
        }

        return $orderProducts;
    }

    private function getPendingOrders($orders)
    {
        $pendingOrders = array();

        foreach ($orders as $order) {
            if ($order[1][0][1] == false) {
                array_push($pendingOrders, $order);
            }
        }

        return $pendingOrders;
    }

    private function acceptOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->accepted = true;
        $order->save();

        ChatController::createMessage(env('CONFIRM_MESSAGE'), 'S', $orderId);

        Log::info('The order with id: ' . $orderId , ' has been accepted.');
    }

    private function denyOrder($orderId)
    {
        $order = Order::find($orderId);
        $products = $order->products;

        foreach($products as $product)
        {
            $product->sold = false;
            $product->enabled = true;
            $product->save();
            $order->products()->detach($product->id);
        }

        $order->chats()->delete();
        $order->delete();

        Log::info('The order with id: ' . $orderId , ' has been denied.');
    }

    public function profile(Request $request)
    {
        if ($request->has('accept')) {
            $this->acceptOrder($request->input('pendingOrder'));
        } elseif ($request->has('deny')) {
            $this->denyOrder($request->input('pendingOrder'));
        }

        $storeExists = $this->checkUserHasStore(Auth::id());
        $orders = $this->getOrderHistory('buyer_id');
        $sellerOrders = $this->getOrderHistory('seller_id');
        $pendingOrders = $this->getPendingOrders($sellerOrders);
        $storeName = Store::getOwnStoreName();

        $data = ['storeExists' => $storeExists, 'orders' => $orders, 'sellerOrders' => $sellerOrders, 'pendingOrders' => $pendingOrders, 'storeName' => $storeName];

        return view('pages.profile', $data);
    }

    public function changePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return back();
    }

    public function checkUserHasStore($userId)
    {
        return Store::where('user_id', $userId)->exists();
    }

    public function createStore(Request $request)
    {
        // REVISAR!!!!!!!!!!!

        // $this->validate($request, [
        //     'name' => 'required',
        //     'logo' => 'required|image|max:2048',
        // ]);

        $imagePath = $this->storeImage($request->file('image'), 'logoShop');

        Store::create([
            'name' => $request->input('name'),
            'logo' => $imagePath,
            'user_id' => Auth::id()
        ]);

        return back();
    }

    public function upload(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('image')) {
            $imagePath = $this->storeImage($request->file('image'), 'logoProfile');
            $user->pfp = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'La información ha sido actualizada correctamente.');
    }

    private function storeImage($image, $prefix)
    {
        $userId = Auth::id();
        $imageName = "{$prefix}{$userId}.{$image->getClientOriginalExtension()}";
        $imagePath = "storage/images/{$userId}/{$imageName}";
        $image->storeAs("public/images/{$userId}", $imageName);
        return $imagePath;
    }
}