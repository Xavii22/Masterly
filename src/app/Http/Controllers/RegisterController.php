<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showRegistrationForm() {
        return view('pages.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $createUser = $this->create($data);

        $token = Str::random(64);

        UserVerify::create([
            'id' =>$createUser->id,
            'token' => $token
        ]);

        // Mail::send('pages.emailVerificationEmail', ['token' => $token], function($message) use($request){
        //     $message->to($request->email);
        //     $message->subject('Email Verification Mail');
        // });

        session()->flash('status', "User {$data['name']} created with success!");
        return redirect()->route('pages.login');
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'pfp' => '',
            'password' => Hash::make($data['password'])
        ]);
    
        $localStorage = $data['localStorage'] ?? [];
        $products = Product::whereIn('id', $localStorage)->get();
    
        $cart = Cart::create(['user_id' => $user->id]);
        $cart->products()->attach($products->pluck('id')->toArray());
    
        return $user;
    }

    public function verifyAccount ($token) 
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';

        if(!is_null ($verifyUser)){

            if(!$verifyUser->is_email_verified){
                
                $user = $verifyUser->user()->get();
                $user->is_email_verified = 1;
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        return redirect()->route('pages.login')->with('message', $message);
    }
}
