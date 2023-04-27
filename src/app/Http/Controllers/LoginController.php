<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showLoginForm() {
        return view('pages.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended(route('pages.home')); 
        }

        session()->flash('status','Incorrect username or password!');

        return redirect(route('pages.login'));
    }

    public function logout() {
        session()->flush(); 
        Auth::logout(); 

        return redirect()->route('pages.landing');
    }
}
