<?php

use Inertia\Inertia;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SeriController;
use App\Http\Controllers\UserController;

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
Route::post('/peminjaman', [PeminjamanController::class, 'create']);
Route::post('/peminjaman/webhook', [PeminjamanController::class, 'webhook']);

// #region //*=============== user ===============

Route::inertia('/auth/register', 'auth/register')->name('auth.register.view');
Route::inertia('/auth/login', 'auth/login')->name('auth.login.view');
Route::post('/auth/register', [UserController::class, 'storeUser'])->name('auth.register');
Route::post('/auth/login', [UserController::class, 'storeLogin'])->name('auth.login');
Route::post('/auth/logout', [UserController::class, 'destroyLogin'])->name('auth.logout');
Route::get('/users', [UserController::class, 'getUserList']);

// #region //*=============== seri ===============

Route::get('/seri', [SeriController::class, 'getSeriList']);
Route::get('/seri/{id}', [SeriController::class, 'getDetailSeri']);

// #region //*=============== cart ===============

Route::get('/cart', [CartController::class, 'getCartUser']);
Route::post('/cart', [CartController::class, 'createCart'])->name('create-cart');
Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('delete-cart');
Route::delete('/cart/volume/{id}', [CartController::class, 'deleteCartByVolumeId'])->name('delete-cart-volume');


Route::get('/queue', function () {
    SendEmail::dispatch();
    return "Email sent";
});

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');
