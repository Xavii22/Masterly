<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;

class ProfileController extends Controller
{
    private function getOrderHistory($actor)
    {
        $orderProducts = array();
        $orders = Order::where($actor, Auth::id())->get()->groupBy('number');

        foreach ($orders as $key => $order) {
            $orderProducts[$key][0] = $order[0]->created_at->format('d-m-Y');

            foreach ($order as $key2 => $vendorOrder) {
                $orderProducts[$key][1][$key2][0] = $vendorOrder->products()->wherePivot('order_id', $vendorOrder->id)->get();
                $orderProducts[$key][1][$key2][1] = $vendorOrder->accepted;
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
        $storeExists = $this->checkUserHasStore(Auth::id());
        $orders = $this->getOrderHistory('buyer_id');
        $sellerOrders = $this->getOrderHistory('seller_id');

        $data = ['storeExists' => $storeExists, 'orders' => $orders, 'sellerOrders' => $sellerOrders];
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
