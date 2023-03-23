<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return 'Landing page';
});

Route::get('/home', [HomeController::class, 'home'])->name('pages.home');

Route::get('/product/{id}', [HomeController::class, 'showProduct'])->name('pages.product');

//Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/cart', [CartController::class, 'cart'])->name('pages.cart');

Route::post('/cart', [CartController::class, 'queryProducts'])->name('pages.cart');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('pages.login');
Route::get('/logout',[LoginController::class, 'logout'])->name('pages.logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('pages.register');

Route::middleware('auth')->group(function () {

});