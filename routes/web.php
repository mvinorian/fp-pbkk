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

Route::group(
    ['middleware' => ['user'],],
    function () {
    }
);

Route::group(
    ['middleware' => ['admin'],],
    function () {
    }
);

// #region //*============ peminjaman ============

Route::post('/peminjaman', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman/webhook', [PeminjamanController::class, 'webhook']);
Route::get('/peminjaman', [PeminjamanController::class, 'getMyPeminjamanList'])->name('peminjaman.index');

// #region //*=============== user ===============

Route::inertia('/auth/register', 'auth/register')->name('auth.register.index');
Route::inertia('/auth/login', 'auth/login')->name('auth.login.index');
Route::post('/auth/register', [UserController::class, 'storeUser'])->name('auth.register');
Route::post('/auth/login', [UserController::class, 'storeLogin'])->name('auth.login');
Route::post('/auth/logout', [UserController::class, 'destroyLogin'])->name('auth.logout');
Route::get('/users', [UserController::class, 'getUserList']);

// #region //*=============== seri ===============

Route::get('/seri', [SeriController::class, 'getSeriList'])->name('seri.index');
Route::get('/seri/{id}', [SeriController::class, 'getDetailSeri'])->name('seri.detail')->middleware(['admin']);
Route::get('/seri/create', [SeriController::class, 'createSeriView'])->name('seri.create.index');
Route::post('/seri/create', [SeriController::class, 'create_seri'])->name('seri.create')->middleware(['admin']);
Route::post('/seri/genre/create', [SeriController::class, 'createGenre'])->name('seri.genre.create')->middleware(['admin']);
Route::post('/seri/penerbit/create', [SeriController::class, 'createPenerbit'])->name('seri.penerbit.create')->middleware(['admin']);
Route::post('/seri/penulis/create', [SeriController::class, 'createPenulis'])->name('seri.penulis.create')->middleware(['admin']);

// #region //*=============== cart ===============

Route::get('/cart', [CartController::class, 'getCartUser'])->name('cart.index');
Route::post('/cart', [CartController::class, 'createCart'])->name('cart.create');
Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');
Route::delete('/cart/volume/{id}', [CartController::class, 'deleteCartByVolumeId'])->name('cart.delete.volume');

// #region //*=============== home ===============

Route::get('/', function () {
    return redirect(route('seri.index'));
});


Route::get('/queue', function () {
    SendEmail::dispatch();
    return "Email sent";
});
