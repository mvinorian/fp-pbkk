<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Jobs\SendEmail;
use Inertia\Inertia;

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

Route::get('/users', [UserController::class, 'getUserList']);

Route::post('/users', [UserController::class, 'createUser']);

Route::get('/queue', function () {
    SendEmail::dispatch();
    return "Email sent";
});

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('about');
})->name('about');
