<?php

use App\Http\Controllers\MatrimonyController;

Route::middleware(['web'])->group(function () {
    Route::group([
        'prefix' => 'matrimony',
        'as' => 'matrimony.'
    ], function () {
        Route::get('/', [MatrimonyController::class, 'index'])->name('index');
        Route::post('/matrimony/search', [MatrimonyController::class, 'search'])->name('matrimony.search');
        Route::get('/search-results', [MatrimonyController::class, 'searchresults'])->name('searchresults');
        Route::get('/pricing', [MatrimonyController::class, 'price'])->name('price');
        Route::get('/profile-details/{id}', [MatrimonyController::class, 'profiledetails'])->name('profile-details');
        Route::get('/otp', [MatrimonyController::class, 'otp'])->name('otp');

        // Dashboard
        Route::get('/dashboard', [MatrimonyController::class, 'dashboard'])->name('dashboard');

        // KYC
        Route::get('/user-details', [MatrimonyController::class, 'userdetails'])->name('user-details');
        Route::post('/user-details', [MatrimonyController::class, 'storeUserDetails'])->name('user-details.store');

        // Preference
        Route::get('/preference', [MatrimonyController::class, 'preference'])->name('preference');
        Route::post('/preference', [MatrimonyController::class, 'storePreference'])->name('preference.store');

        // Profile
        Route::get('/profile', [MatrimonyController::class, 'profile'])->name('profile');

        // Filter
        Route::match(['get', 'post'], '/filter', [MatrimonyController::class, 'filter'])->name('filter');
        
        // Send profile request
        Route::post('/profile/send-request/{profile}', [MatrimonyController::class, 'sendRequest'])
        ->name('profile.send-request')
        ->middleware('auth');

        // Accept and deny requests
        Route::post('/request/accept', [MatrimonyController::class, 'accept'])->name('request.accept');
        Route::post('/request/deny', [MatrimonyController::class, 'deny'])->name('request.deny')->middleware('auth');

        // Edit profile
        Route::get('/edit-profile/{id}', [MatrimonyController::class, 'editProfile'])->name('edit-profile');
        Route::put('/update-profile/{id}', [MatrimonyController::class, 'updateMainProfile'])->name('update-profile');

        Route::get('/profile-listing', [MatrimonyController::class, 'profilelisting'])->name('profile-listing');
        Route::post('/profile-listing/store', [MatrimonyController::class, 'storeProfileListing'])->name('profilelisting.store');

        // Update Profile Listing
        Route::get('/update-profile/{profile_id?}', [MatrimonyController::class, 'updateProfile'])->name('update-profile');

        Route::put('/submit-update-profile/{profile_id}', [MatrimonyController::class, 'submitUpdateProfile'])->name('submit-update-profile');

        Route::get('/profile-lists', [MatrimonyController::class, 'profilelists'])->name('profile-lists');

        Route::get('/requests-lists', [MatrimonyController::class, 'requestlists'])->name('requests-lists');

        // Fetch state and cities
        Route::get('/get-states/{country_id}', [MatrimonyController::class, 'getStates'])->name('get-states');

        Route::get('/get-cities/{state_id}', [MatrimonyController::class, 'getCities'])->name('get-cities');
        Route::get('/check-subscription', [MatrimonyController::class, 'checkSubscription'])->name('check.subscription');
    });
});

Route::post('/decrement-profile', [MatrimonyController::class, 'decrementProfileCount'])->name('decrement.profile');
Route::post('/unlock-profile', [MatrimonyController::class, 'unlockProfile'])->name('matrimony.unlock.profile');
