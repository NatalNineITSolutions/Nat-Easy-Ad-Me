<?php

use App\Http\Controllers\MatrimonyController;

Route::middleware(['web'])->group(function () {
    Route::group([
        'prefix' => 'matrimony',
        'as' => 'matrimony.'
    ], function () {
        Route::get('/', [MatrimonyController::class, 'index'])->name('index');
        Route::get('/register', [MatrimonyController::class, 'register'])->name('register');
        Route::post('/register', [MatrimonyController::class, 'store'])->name('store');
        Route::get('/login', [MatrimonyController::class, 'showLoginForm'])->name('login.form');
        Route::post('/login', [MatrimonyController::class, 'login'])->name('login');
        Route::get('/pricing', [MatrimonyController::class, 'price'])->name('price');
        Route::get('/profile-details', [MatrimonyController::class, 'profiledetails'])->name('profile-details');
        Route::get('/otp', [MatrimonyController::class, 'otp'])->name('otp');
    });
});