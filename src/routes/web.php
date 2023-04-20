<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'landing'])->name('pages.landing');

Route::get('/home', [HomeController::class, 'home'])->name('pages.home');

Route::get('/product/{id}', [HomeController::class, 'showProductDetails'])->name('pages.product');

Route::get('/cart', [CartController::class, 'cart'])->name('pages.cart');

Route::post('/cart', [CartController::class, 'queryProducts'])->name('pages.cart');

Route::get('/store/{id}', [HomeController::class, 'home'])->name('pages.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('pages.login');
Route::get('/logout',[LoginController::class, 'logout'])->name('pages.logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('pages.register');

//Send-email-verification
Route::get('dashboard', [RegisterController::class, 'dashboard'])->middleware(['is_verify_email']); 
Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify'); 
Route::middleware('auth')->group(function () {

});