<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;

class ProfileController extends Controller
{
    public function profile()
    {
        $storeExists = $this->checkUserHasStore(Auth::id());
        $data = ['storeExists' => $storeExists];
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