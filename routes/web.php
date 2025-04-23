<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuth;

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

// Auth rotaları
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Yönetici paneline giriş gerektiren rotalar
Route::middleware([ManagerAuth::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // API Endpoint'leri
    Route::get('/api/artists', [DashboardController::class, 'getAssociatedArtists']);
    
    // Sanatçı slug URL'i için özel rota (sanatçı resource rotasından ÖNCE tanımlanmalı)
    Route::get('/artists/{slug}', [ArtistController::class, 'showBySlug'])->name('artists.show.slug')->where('slug', '[a-z0-9\-]+');
    
    // Sanatçı yönetimi
    Route::resource('artists', ArtistController::class)->except(['index']);
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    
    // Sanatçı oluşturma aşamaları için ekstra rotalar
    Route::get('/artists/create/step1', [ArtistController::class, 'createStep1'])->name('artists.create.step1');
    Route::post('/artists/create/process-step1', [ArtistController::class, 'processStep1'])->name('artists.process.step1');
    Route::get('/artists/create/step2/{plan_id}', [ArtistController::class, 'createStep2'])->name('artists.create.step2');
    Route::get('/artists/payment/success/{id}', [ArtistController::class, 'paymentSuccess'])->name('artists.payment.success');

    // Abonelik rotaları
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/callback', [SubscriptionController::class, 'callback'])->name('subscriptions.callback');
    Route::get('/subscriptions/my', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::get('/subscriptions/{id}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
});
