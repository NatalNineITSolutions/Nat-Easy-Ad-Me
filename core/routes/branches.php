<?php

use App\Http\Controllers\Frontend\BranchController;
use Illuminate\Support\Facades\Route;

Route::controller(BranchController::class)->group(function () {
    Route::match(['get', 'post'], 'branch-login', 'branchlogin')->name('branchlogin');
    Route::match(['get', 'post'], 'branch-logout', 'branchlogout')->name('branchlogout');
});

Route::controller(BranchController::class)->group(function () {
    Route::group(['prefix' => 'branchdashboard'], function () {
        Route::get('info', 'branchdashboard')->name('branchdashboard');
    });
    Route::get('productupload', 'productUpload')->name('upload.products');
});