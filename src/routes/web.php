<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'login'])->name('pages.login');

Route::get('/cart', [CartController::class, 'cart'])->name('pages.cart');

Route::post('/cart', [CartController::class, 'queryProducts'])->name('pages.cart');

