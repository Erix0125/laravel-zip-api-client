<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Guest routes for API authentication
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('login', [AuthController::class, 'login'])
        ->name('auth.login');
});

// Protected routes with API token middleware
Route::middleware('api_token')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});
