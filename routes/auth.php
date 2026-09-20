<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])
        ->middleware('throttle:6,1')
        ->name('post-login');
});

Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('logout');
