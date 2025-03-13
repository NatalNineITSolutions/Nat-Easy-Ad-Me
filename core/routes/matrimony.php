<?php

use App\Http\Controllers\MatrimonyController;

Route::group([
    'prefix' => 'matrimony',
    'as' => 'matrimony.'
], function () {
    Route::get('/', [MatrimonyController::class, 'index'])->name('index');
    Route::get('/register', [MatrimonyController::class, 'register'])->name('register');
    Route::post('/register', [MatrimonyController::class, 'store'])->name('store');
    Route::get('/pricing', [MatrimonyController::class, 'price'])->name('price');
});
