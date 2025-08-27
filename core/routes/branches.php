<?php

use App\Http\Controllers\Frontend\BranchController;
use Illuminate\Support\Facades\Route;

Route::controller(BranchController::class)->group(function () {
    Route::match(['get', 'post'], 'branch-login', 'branchlogin')->name('branchlogin');
    Route::match(['get', 'post'], 'branch-logout', 'branchlogout')->name('branchlogout');
});

Route::prefix('branch')->controller(BranchController::class)->group(function () {
    Route::get('info', 'branchdashboard')->name('branch.dashboard');

    Route::get('products', 'allProducts')->name('branch.products.all');
    
    // Create / Store
    Route::get('productupload', 'productUpload')->name('branch.upload.products');
    Route::post('products/store', 'store')->name('branch.products.store');

    // Edit / Update
    Route::get('products/edit/{id}', 'edit')->name('branch.products.edit');
    Route::put('products/update/{id}', 'update')->name('branch.products.update');

    // Delete
    Route::delete('products/delete/{id}', 'destroy')->name('branch.products.delete');
});

Route::prefix('branch')->name('branch.')->controller(BranchController::class)->group(function () {
    Route::post('media-upload', 'uploadMediaFile')->name('upload.media.file');
    Route::post('media-upload/all', 'allUploadMediaFile')->name('upload.media.file.all');
    Route::post('media-upload/alt', 'altChangeUploadMediaFile')->name('upload.media.file.alt.change');
    Route::post('media-upload/loadmore', 'getImageForLoadmore')->name('upload.media.file.loadmore');
    Route::get('media-upload/page', 'allUploadMediaImagesForPage')->name('upload.media.images.page')->middleware('permission:media-upload');
    Route::post('media-upload/delete', 'deleteUploadMediaFile')->name('upload.media.file.delete')->middleware('permission:media-upload-delete');
});