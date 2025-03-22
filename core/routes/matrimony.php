<?php

use App\Http\Controllers\MatrimonyController;

Route::middleware(['web'])->group(function () {
    Route::group([
        'prefix' => 'matrimony',
        'as' => 'matrimony.'
    ], function () {
        Route::get('/', [MatrimonyController::class, 'index'])->name('index');
        Route::get('/pricing', [MatrimonyController::class, 'price'])->name('price');
        Route::get('/profile-details', [MatrimonyController::class, 'profiledetails'])->name('profile-details');
        Route::get('/otp', [MatrimonyController::class, 'otp'])->name('otp');

        // KYC
        Route::get('/user-details', [MatrimonyController::class, 'userdetails'])->name('user-details');
        Route::post('/user-details', [MatrimonyController::class, 'storeUserDetails'])->name('user-details.store');

        // Preference
        Route::get('/preference', [MatrimonyController::class, 'preference'])->name('preference');
        Route::post('/preference', [MatrimonyController::class, 'storePreference'])->name('preference.store');

        // Profile
        Route::get('/profile', [MatrimonyController::class, 'profile'])->name('profile');
        Route::get('/profile-listing', [MatrimonyController::class, 'profilelisting'])->name('profile-listing');
        Route::post('/profile-listing/store', [MatrimonyController::class, 'storeProfileListing'])->name('profilelisting.store');

        Route::get('/profile-lists', [MatrimonyController::class, 'profilelists'])->name('profile-lists');
    });
});