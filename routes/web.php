<?php

/**
 * File: web.php
 * Description: Web routes for Sherwood Laundry
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscribeController;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Marketing Routes
|--------------------------------------------------------------------------
|
| These routes are publicly accessible and handle the marketing site,
| email subscriptions, and legal pages.
|
*/

Route::get('/', [PageController::class, 'landing'])->name('home');
Route::get('/success', [PageController::class, 'success'])->name('success');
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe');

Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('refund-policy');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user authentication including registration, login,
| password reset, and email verification. We use Livewire components
| for interactive forms and Laravel Fortify for the backend.
|
*/

// Registration route (Livewire component)
Route::get('/register', Register::class)
    ->middleware('guest')
    ->name('register');

// Login route (placeholder - will be implemented with Livewire)
Route::get('/login', function () {
    // TODO: Implement login with Livewire component
    return redirect()->route('register');
})->middleware('guest')->name('login');

// Temporary onboarding placeholder route
Route::get('/onboarding', function () {
    return view('pages.onboarding-placeholder');
})->middleware('auth')->name('onboarding');
