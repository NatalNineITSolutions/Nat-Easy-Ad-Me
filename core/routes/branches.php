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

    Route::get('products', 'allProducts')->name('products.all');
    Route::get('productupload', 'productUpload')->name('upload.products');
    // Store Product
    Route::post('products/store', 'store')->name('branch.products.store');
});

Route::prefix('branch')->name('branch.')->controller(BranchController::class)->group(function () {
    Route::post('media-upload', 'uploadMediaFile')->name('upload.media.file');
    Route::post('media-upload/all', 'allUploadMediaFile')->name('upload.media.file.all');
    Route::post('media-upload/alt', 'altChangeUploadMediaFile')->name('upload.media.file.alt.change');
    Route::post('media-upload/loadmore', 'getImageForLoadmore')->name('upload.media.file.loadmore');
    Route::get('media-upload/page', 'allUploadMediaImagesForPage')->name('upload.media.images.page')->middleware('permission:media-upload');
    Route::post('media-upload/delete', 'deleteUploadMediaFile')->name('upload.media.file.delete')->middleware('permission:media-upload-delete');
});