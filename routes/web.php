<?php

use App\Http\Controllers\SupabaseTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('events.index');
});

Route::get('/supabase-test', [SupabaseTestController::class, 'index']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Etkinlikler sayfası
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');

// Auth işlemleri
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
