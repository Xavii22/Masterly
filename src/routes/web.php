<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EditProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CreateProductController;
use App\Http\Controllers\HeaderController;
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
Route::post('/home', [HomeController::class, 'toggleProductFromCart'])->name('pages.home');
Route::post('/home-init', [HomeController::class, 'getProductsFromCart'])->name('pages.home-init');

Route::get('/product/{id}', [HomeController::class, 'showProductDetails'])->name('pages.product');

Route::get('/cart', [CartController::class, 'cart'])->name('pages.cart');
Route::post('/cart', [CartController::class, 'queryProducts'])->name('pages.cart');

Route::get('/store/{id}', [HomeController::class, 'home'])->name('pages.store');

Route::get('/manageStore/{id}', [HomeController::class, 'home'])->name('pages.manageStore');

Route::get('/createProduct', [CreateProductController::class, 'creator'])->name('pages.creator');
Route::post('/createProduct', [CreateProductController::class, 'createProduct'])->name('pages.createProduct');

Route::get('/profile', [ProfileController::class, 'profile'])->name('pages.profile');
Route::post('/upload', [ProfileController::class, 'upload'])->name('pages.upload');
Route::post('/changePassword', [ProfileController::class, 'changePassword'])->name('pages.changePassword');
Route::post('/createStore', [ProfileController::class, 'createStore'])->name('pages.createStore');


Route::get('/editProduct/{id}', [EditProductController::class, 'editProduct'])
    ->name('pages.editProduct')
    ->middleware('App\Http\Middleware\CheckUserAccessToEditProduct');

Route::delete('/editProduct/{id}', [EditProductController::class, 'deleteProduct'])
    ->name('pages.deleteProduct')
    ->middleware('App\Http\Middleware\CheckUserAccessToEditProduct');

Route::post('/editProduct/{id}', [EditProductController::class, 'manageEditProductForms'])
    ->name('pages.manageEditProductForms')
    ->middleware('App\Http\Middleware\CheckUserAccessToEditProduct');

Route::get('/order', [OrderController::class, 'order'])->name('pages.order');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('pages.login');
Route::get('/logout', [LoginController::class, 'logout'])->name('pages.logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('pages.register');

//Send-email-verification
Route::get('dashboard', [RegisterController::class, 'dashboard'])->middleware(['is_verify_email']);
Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');
Route::middleware('auth')->group(function () {
});

// Errors
Route::get('/productNotFound', [ErrorController::class, 'productNotFound'])->name('errors.productNotFound');
Route::get('/storeNotFound', [ErrorController::class, 'storeNotFound'])->name('errors.storeNotFound');

// Route::get('/defaultError', [ErrorController::class, 'defaultError'])->name('errors.defaultError');

// Route::fallback(function () {
//     abort(404);
// });