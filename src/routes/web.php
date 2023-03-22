<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::get('/login', [LoginController::class, 'login'])->name('pages.login');

Route::get('/search', [HomeController::class, 'search'])->name('search');

//Se accede como /admin/logs
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
