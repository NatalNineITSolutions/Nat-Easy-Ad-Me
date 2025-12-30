<?php

use App\Http\Controllers\Frontend\User\ListingFavoriteController;
use App\Http\Controllers\Frontend\User\NotificationController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\MLMController;
use App\Http\Controllers\Frontend\User\UserController;
use App\Http\Controllers\Frontend\User\AccountSettingController;
use App\Http\Controllers\Frontend\User\ListingController;

// client

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    Route::middleware(['globalVariable', 'maintains_mode', 'setlang'])->group(function () {
        Route::get('/mlm/add-member', [MLMController::class, 'addNewMember'])->name('mlm.addNewMember');
    });

    Route::group(['middleware' => ['auth', 'globalVariable', 'maintains_mode', 'setlang']], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('profile/logout', 'logout')->name('logout');
        });
    });

    Route::group(['middleware' => ['auth', 'userEmailVerify', 'globalVariable', 'maintains_mode', 'setlang']], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('profile/settings', 'profile')->name('profile');
            Route::post('profile/edit-profile', 'edit_profile')->name('profile.edit');
            Route::match(['get', 'post'], 'profile/identity-verification', 'identity_verification')->name('identity.verification');
            Route::post('profile/check-password', 'check_password')->name('password.check');
            Route::match(['get', 'post'], 'profile/change-password', 'change_password')->name('password');
            Route::get('profile/detail', [DashboardController::class, 'showProfile'])->name('profile.show');
        });

        // user account settings
        Route::controller(AccountSettingController::class)->group(function () {
            Route::match(['get', 'post'], '/account-settings', 'userAccountSetting')->name('account.settings');
            Route::post('/account-deactive', 'accountDeactive')->name('account.deactive');
            Route::get('/account-deactive/cancel/{id}', 'accountDeactiveCancel')->name('account.deactive.cancel');
            Route::post('account/delete', 'accountDelete')->name('account.delete');
        });

        // notifications
        Route::controller(NotificationController::class)->group(function () {
            Route::group(['prefix' => 'notification'], function () {
                Route::post('read', 'read_notification')->name('notification.read');
            });
        });

        //dashboard
        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'dashboard'], function () {
                Route::get('info', 'dashboard')->name('dashboard');
            });
        });

        //genology
        Route::controller(DashboardController::class)->group(function () {
            Route::prefix('genology')->group(function () {
                Route::get('info', 'genology')->name('genology');
                Route::get('user/mlm/children/{id}', 'getChildren')->name('user.mlm.children');
                Route::get('team/view/{id}', 'teamView')->name('team.view');
            });
        });

        // My Team
        Route::controller(DashboardController::class)->group(function () {
            Route::prefix('team')->group(function () {
                Route::get('view/{id}', 'teamView')->name('team.view');
            });
        });


        // Referral
        Route::controller(DashboardController::class)->group(function () {
            Route::prefix('referral')->group(function () {
                Route::get('referral/{id}', 'referralView')->name('referral.view');
            });
        });

        // Route::get('/mlm/add-member', [MLMController::class, 'addNewMember'])->name('mlm.addNewMember');

        // job seeker
        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'info'], function () {
                Route::match(['get', 'post'], '/add-job', 'addjobListing')->name('addjob.listing');
                Route::get('/job-listings', 'getjobseeker')->name('job.info');
                Route::get('/edit-job/{id}', 'editJob')->name('edit.job');
                Route::put('/update-job/{id}', 'updateJob')->name('update.job');
                Route::delete('/delete-job/{id}', 'deleteJob')->name('delete.job');
            });
        });

        // Products
        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'info'], function () {
                Route::get('/products', 'productSlider')->name('products');
                Route::get('/product-details/{id}', 'productDetails')->name('product.details');
                Route::get('/all-products', 'allProducts')->name('all.products');
                Route::get('/product-buy', 'productBuyForm')->name('product.buy');
                Route::post('/get-states', 'userGetStates')->name('get.states');
                Route::post('/get-cities', 'userGetCities')->name('get.cities');
                Route::post('/place-order', 'storeOrder')->name('order.store');
                Route::post('/add-to-cart', 'addToCart')->name('add.to.cart');
                Route::post('/update-cart-quantity', 'updateCartQuantity')->name('cart.update.quantity');
                Route::post('/remove-cart-item', 'removeCartItem')->name('cart.remove');
                Route::get('/check-cart', 'checkProductInCart')->name('check.cart');
                Route::post('/update-delivery', 'updateDeliveryCharge')->name('cart.update.delivery');
                Route::post('/get-delivery-charges', 'getChargesByState')->name('get.delivery.charges');
            });
        });

        // Order History
        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'info'], function () {
                Route::get('/order-history', 'orderHistory')->name('order.history');
                Route::get('/view-order-details/{order}', 'viewOrderDetails')->name('order.view.details');
                Route::get('/order/invoice/{order}', 'downloadInvoice')->name('order.invoice.download');
                Route::get('/view-order-product-details/{order}/{index}', 'viewProductDetails')->name('order.view.details.product');
                Route::get('/order/invoice/{order}/{index}', 'downloadProductInvoice')->name('order.invoice.download.product');
            });
        });

        // User Reports
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/user-reports', 'userReports')->name('user.reports');
        });


        // Income 
        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'info'], function () {
                Route::match(['get', 'post'], '/income', 'viewincome')->name('income');
                Route::get('/income-statement/download', 'downloadIncomePDF')->name('income.pdf');
            });
        });

        Route::controller(DashboardController::class)->group(function () {
            Route::group(['prefix' => 'info'], function () {
                Route::get('/bv-history', 'bvhistory')->name('bv.history');
            });
        });

        // add listing
        Route::controller(ListingController::class)->group(function () {
            Route::group(['prefix' => 'listing'], function () {
                Route::get('all', 'allListing')->name('all.listing');
                Route::match(['get', 'post'], '/add', 'addListing')->name('add.listing');
                Route::match(['get', 'post'], '/edit/{id?}', 'editListing')->name('edit.listing');
                Route::post('delete/{id?}', 'deleteListing')->name('delete.listing');
                Route::post('published-on-off/{id}', 'listingPublishedStatus')->name('listing.published.status');
            });
        });

        //seller profile verify
        Route::post('user-profile-verify', [AccountSettingController::class, 'userProfileVerify'])->name('profile.verify');
    });

    // user  listing favorite items
    Route::group(['middleware' => ['globalVariable', 'maintains_mode', 'setlang']], function () {
        Route::controller(ListingFavoriteController::class)->group(function () {
            Route::get('favorite/listing/all', 'ListingFavoriteAll')->name('listing.favorite.all');
        });
    });

    Route::post('/get-states-by-country', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'status' => 'success',
        'states' => \Modules\CountryManage\app\Models\State::where('country_id', $request->country_id)
            ->where('status', 1)
            ->select('id', 'state')
            ->get()
    ]);
})->name('frontend.get.states');

Route::post('/get-districts-by-state', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'status' => 'success',
        'districts' => \Modules\CountryManage\app\Models\District::where('state_id', $request->state_id)
            ->where('status', 1)
            ->select('id', 'district')
            ->get()
    ]);
})->name('frontend.get.districts');

Route::post('/get-cities-by-district', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'status' => 'success',
        'cities' => \Modules\CountryManage\app\Models\City::where('district_id', $request->district_id)
            ->where('status', 1)
            ->select('id', 'city')
            ->get()
    ]);
})->name('frontend.get.cities');

});
