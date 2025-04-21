<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductListingController;
use App\Http\Controllers\Api\ListingApiController;
use App\Http\Controllers\Api\MatrimonyController;
use App\Http\Controllers\Api\BuyMembershipApiController;
use App\Http\Controllers\Api\MembershipApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "api" middleware group.
|
*/

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Partner Verification Routes
Route::post('partner/verify', [AuthController::class, 'verifyPartner']);

// Home Page Listings
Route::get('/top-listings', [ProductListingController::class, 'getTopListings']);
Route::get('/location-listings', [ProductListingController::class, 'getLocationListings']);
Route::get('/job-listings', [ProductListingController::class, 'getJobListings']);
Route::get('/recent-listings', [ProductListingController::class, 'getRecentListings']);

// Category
Route::get('/categories', [ListingApiController::class, 'getCategories']);
Route::get('/subcategories', [ListingApiController::class, 'getSubcategories']);
Route::get('/childcategories', [ListingApiController::class, 'getChildcategories']);
Route::get('/profile-lists', [MatrimonyController::class, 'profileLists']);
Route::get('/profile/{profile_id}', [MatrimonyController::class, 'getProfileDetails']);





Route::post('/listings/filter', [ListingApiController::class, 'filterListings']);

// ProductDetails
Route::get('/listing-details/{identifier}', [ProductListingController::class, 'getListingDetails']);

Route::get('/memberships', [MembershipApiController::class, 'getMembershipsByCategory']);


// Protected Routes (using Sanctum for authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/add-listing', [ListingApiController::class, 'addListing']);

    Route::post('/profile', [MatrimonyController::class, 'storeProfile']);
    Route::post('/membership/update', [BuyMembershipApiController::class, 'updateMembership']);

    // You can add more protected routes here
});
