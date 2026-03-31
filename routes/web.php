<?php

/**
 * File: web.php
 * Description: Web routes for Sherwood Laundry
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscribeController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
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

// Login route (Livewire component)
Route::get('/login', \App\Livewire\Auth\Login::class)
    ->middleware('guest')
    ->name('login');

// Forgot password route (Livewire component)
Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');

// Reset password route (Livewire component)
Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
|
| These routes handle email verification for new users. Unverified users
| are redirected to the verification notice page. The verification link
| in the email uses a signed URL for security.
|
*/

// Email verification notice page - shows message to check email (Livewire component)
Route::get('/email/verify', VerifyEmail::class)
    ->middleware('auth')
    ->name('verification.notice');

// Handle email verification link click - verifies the user's email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    // Log the verification link click
    Log::info('Email verification link clicked', [
        'user_id' => $request->user()->id,
        'email' => $request->user()->email,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    $request->fulfill();

    // Log successful verification
    Log::info('Email verified successfully', [
        'user_id' => $request->user()->id,
        'email' => $request->user()->email,
    ]);

    return redirect()->route('onboarding')->with('verified', true);
})->middleware(['auth', 'signed'])->name('verification.verify');

// Temporary onboarding placeholder route - requires verified email
Route::get('/onboarding', function () {
    return view('pages.onboarding-placeholder');
})->middleware(['auth', 'verified'])->name('onboarding');
