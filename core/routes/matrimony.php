<?php

use App\Http\Controllers\MatrimonyController;

Route::get('/matrimony', [MatrimonyController::class, 'index'])->name('matrimony.index');
Route::get('/matrimony/register', [MatrimonyController::class, 'register'])->name(name: 'matrimony.register');
Route::post('/matrimony/register', [MatrimonyController::class, 'store'])->name('matrimony.store');
Route::get('/matrimony/pricing', [MatrimonyController::class, 'price'])->name(name: 'matrimony.price');