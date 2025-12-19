<?php

/**
 * File: web.php
 * Description: Web routes for Sherwood Laundry
 * Copyright: 2025 Cloudmanic Labs, LLC
 * Date: 2025-12-18
 */

use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'landing'])->name('home');
Route::get('/success', [PageController::class, 'success'])->name('success');
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe');
