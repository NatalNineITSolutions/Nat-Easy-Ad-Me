<?php

use App\Http\Controllers\Api\GenologyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductListingController;
use App\Http\Controllers\Api\ListingApiController;
use App\Http\Controllers\Api\MatrimonyController;
use App\Http\Controllers\Api\MembershipApiController;
use App\Http\Controllers\Api\EnquiryControllerApi;

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
Route::get('/admin/partner', [AuthController::class, 'getAdminPartner']);
Route::post('admin/verify-partner-id', [AuthController::class, 'verifyAdminPartnerId']);

// Home Page Listings
Route::get('/top-listings', [ProductListingController::class, 'getTopListings']);
Route::get('/location-listings', [ProductListingController::class, 'getLocationListings']);
Route::get('/job-listings', [ProductListingController::class, 'getJobListings']);
Route::get('/recent-listings', [ProductListingController::class, 'getRecentListings']);

// Category
Route::get('/categories', [ListingApiController::class, 'getCategories']);
Route::get('/categories/{id}', [ListingApiController::class, 'getCategory']);
Route::get('/subcategories', [ListingApiController::class, 'getSubcategories']);
Route::get('/childcategories', [ListingApiController::class, 'getChildcategories']);
Route::get('/categories/{slug}/listings', [ListingApiController::class, 'getListingsByCategory']);

Route::post('/listings/filter', [ListingApiController::class, 'filterListings']);

// ProductDetails
Route::get('/listing-details/{identifier}', [ProductListingController::class, 'getListingDetails']);

Route::get('/memberships', [MembershipApiController::class, 'getMembershipsByCategory']);
Route::post('/upload', [ListingApiController::class, 'uploadImage']);
Route::get('/brands', [ProductListingController::class, 'index']);
Route::get('/religion', [MatrimonyController::class, 'religion']);
Route::get('/caste', [MatrimonyController::class, 'caste']);
Route::get('/gothram', [MatrimonyController::class, 'gothram']);
Route::get('/dosham', [MatrimonyController::class, 'dosham']);
Route::get('/income', [MatrimonyController::class, 'income']);
Route::get('/age', [MatrimonyController::class, 'age']);
Route::get('/mother_tongue', [MatrimonyController::class, 'motherTongue']);
Route::get('/zodiac-sign', [MatrimonyController::class, 'zodiacSign']);
Route::get('/star', [MatrimonyController::class, 'star']);
Route::get('/country', [MatrimonyController::class, 'country']);
Route::get('/state/{country_id}', [MatrimonyController::class, 'state']);
Route::get('/city/{state_id}', [MatrimonyController::class, 'city']);


// Protected Routes (using Sanctum for authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/add-listing', [ListingApiController::class, 'addListing']);
    Route::get('/matrimony/profile-lists', [MatrimonyController::class, 'profileLists']);
    Route::get('/matrimony/profile/{profile_id}', [MatrimonyController::class, 'getProfileDetails']);
    Route::post('/matrimony/profile', [MatrimonyController::class, 'storeProfile']);
    Route::post('/membership/update', [MembershipApiController::class, 'updateMembership']);
    Route::post('/enquiry', [EnquiryControllerApi::class, 'store']);
    Route::post('/matrimony/profiles/{profile}/send-request', [MatrimonyController::class, 'sendRequest']);
    Route::post('/matrimony/requests/update-status', [MatrimonyController::class, 'updateStatus']);
    Route::post('/matrimony/user-details', [MatrimonyController::class, 'storeUserDetails']);
    Route::post('/matrimony/preferences', [MatrimonyController::class, 'store']);
    Route::get('/user/listings', [ListingApiController::class, 'allListingsApi']);
    Route::get('/user/enquiries', [EnquiryControllerApi::class, 'allEnquiriesApi']);
    Route::get('/user/profile', [EnquiryControllerApi::class, 'showProfileApi']);
    Route::get('/user/dashboard', [AuthController::class, 'dashboardApi']);
    Route::get('/genology', [GenologyController::class, 'genology']);
    Route::post('/mlm/register-member', [GenologyController::class, 'apiRegisterNewMember']);
    Route::get('/matrimony/received-requests', [MatrimonyController::class, 'getReceivedRequests']);
    Route::get('/profile-requests/accepted', [MatrimonyController::class, 'getAcceptedRequests']);
    Route::get('/profile-requests/rejected', [MatrimonyController::class, 'getRejectedRequests']);
    Route::get('/user-memberships', [MembershipApiController::class, 'index']);
    Route::post('/unlock-profile', [MatrimonyController::class, 'unlockProfile']);
    Route::get('/unlocked-profiles', [MatrimonyController::class, 'getUnlockedProfiles']);
    Route::post('/user/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('/profiles/filter', [MatrimonyController::class, 'apiFilter']);
    Route::get('/profiles', [MatrimonyController::class, 'index']);
});
