<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Listing;
use App\Models\Backend\Advertisement;
use App\Models\Backend\ReportReason;
use Modules\Brand\app\Models\Brand;

class ProductListingController extends Controller
{
    public function getTopListings(Request $request)
    {
        $items = $request->query('items', 10);

        $listings = Listing::where('status', 1)
            ->where('is_published', 1)
            ->when(moduleExists('Membership') && membershipModuleExistsAndEnable('Membership'), function ($query) {
                $query->whereHas('user_membership');
            })
            ->orderBy('view', 'desc')
            ->where('category_id', '!=', 54)
            ->take($items)
            ->inRandomOrder()
            ->get()
            ->map(function ($listing) {
                return [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'description' => $listing->description,
                    'image' => get_attachment_url_by_ids($listing->image),
                    'price' => $listing->category_id != 54 ? amount_with_currency_symbol($listing->price) : null,
                    'address' => $listing->address,
                    'is_featured' => $listing->is_featured,
                    'created_at' => $listing->published_at,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Top listings retrieved successfully',
            'data' => $listings
        ]);
    }

   public function getLocationListings(Request $request)
{
    $items     = $request->query('items', 6);
    $latitude  = $request->query('latitude');
    $longitude = $request->query('longitude');
    $city      = $request->query('city'); // NEW (optional)

    // ---------------------------
    // 1️⃣ PRIMARY: GPS-based search
    // ---------------------------
    $listings = collect();

    if ($latitude && $longitude) {
        $listings = Listing::where('status', 1)
            ->where('is_published', 1)
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->selectRaw(
                "listings.*,
                (6371 * acos(
                    cos(radians(?)) *
                    cos(radians(lat)) *
                    cos(radians(lon) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(lat))
                )) AS distance",
                [$latitude, $longitude, $latitude]
            )
            ->havingRaw('distance <= listings.radius_km')
            ->orderBy('distance', 'asc')
            ->take($items)
            ->get();
    }

    // --------------------------------
    // 2️⃣ FALLBACK: City-based search
    // --------------------------------
    if ($listings->isEmpty() && $city) {
        $listings = Listing::where('status', 1)
            ->where('is_published', 1)
            ->where(function ($q) use ($city) {
                $q->where('address', 'LIKE', "%{$city}%")
                  ->orWhere('location', 'LIKE', "%{$city}%");
            })
            ->orderByDesc('created_at')
            ->take($items)
            ->get();

        // mark as fallback
        $listings = $listings->map(function ($listing) {
            $listing->distance = null;
            $listing->is_city_fallback = true;
            return $listing;
        });
    }

    // ---------------------------
    // RESPONSE FORMAT (unchanged)
    // ---------------------------
    $data = $listings->map(function ($listing) {
        return [
            'id'        => $listing->id,
            'title'     => $listing->title,
            'description' => $listing->description,
            'latitude'  => $listing->lat,
            'longitude' => $listing->lon,
            'price'     => $listing->category_id != 54
                ? amount_with_currency_symbol($listing->price)
                : null,
            'distance'  => $listing->distance !== null
                ? round($listing->distance, 2) . ' km'
                : null,
            'image'     => get_attachment_url_by_ids($listing->image),
            'address'   => $listing->address,
            'is_featured' => $listing->is_featured,
            'created_at' => $listing->published_at,
            'fallback'  => $listing->is_city_fallback ?? false,
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Location-based listings retrieved successfully',
        'data'    => $data
    ]);
}



    public function getJobListings(Request $request)
    {
        try {
            $items = $request->query('items', 6);

            $listings = Listing::where('status', 1)
                ->where('is_published', 1)
                ->where('category_id', 54)
                ->when(moduleExists('Membership') && membershipModuleExistsAndEnable('Membership'), function ($query) {
                    $query->whereHas('user_membership');
                })
                ->orderByDesc('created_at')
                ->take($items)
                ->inRandomOrder()
                ->get()
                ->map(function ($listing) {
                    return [
                        'id' => $listing->id,
                        'title' => $listing->title,
                        'description' => $listing->description,
                        'image' => get_attachment_url_by_ids($listing->image),
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Job listings retrieved successfully.',
                'data' => $listings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving job listings.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getRecentListings(Request $request)
    {
        $items = $request->query('items', 10); // Default to 10 listings

        $listings = Listing::where('status', 1)
            ->where('is_published', 1)
            ->orderByDesc('created_at') // Sort by most recent
            ->take($items)
            ->get()
            ->map(function ($listing) {
                $data = [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'description' => $listing->description,
                    'image' => get_attachment_url_by_ids($listing->image),
                ];

                if ($listing->category_id != 54) {
                    $data['price'] = amount_with_currency_symbol($listing->price);
                }

                return $data;
            });

        return response()->json([
            'success' => true,
            'message' => 'Recent listings retrieved successfully',
            'data' => $listings
        ]);
    }

    public function getListingDetails($identifier)
    {
        $query = Listing::with('user', 'brand', 'tags');

        if (is_numeric($identifier)) {
            $listing = $query->where('id', $identifier)->first();
        } else {
            $listing = $query->where('slug', $identifier)->first();
        }

        if (!$listing) {
            return response()->json([
                'success' => false,
                'message' => 'Listing not found'
            ], 404);
        }

        if ($listing->is_published === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Listing is not published'
            ], 403);
        }

        $related_listings = Listing::where(['user_id' => $listing->user_id, 'status' => 1])
            ->when(membershipModuleExistsAndEnable('Membership'), function ($q) {
                $q->whereHas('user_membership');
            })
            ->inRandomOrder()
            ->where('id', '!=', $listing->id)
            ->take(4)
            ->get();

        $user_total_listings = $listing->user ? Listing::where('user_id', $listing->user->id)->count() : 0;

        $listing->increment('view');

        $report_reasons = ReportReason::where('status', 1)
            ->latest()
            ->take(500)
            ->get();

        // Membership details
        $user_business_hour = false;
        $user_enquiry_form = false;
        $user_membership_badge = false;

        if ($listing->category_id == 54) {
            $user_business_hour = true;
            $user_enquiry_form = true;
            $user_membership_badge = true;
        } elseif (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $membershipUser = optional($listing->user)->membershipUser;
            if ($membershipUser) {
                $user_business_hour = $membershipUser->business_hour === 1;
                $user_enquiry_form = $membershipUser->enquiry_form === 1;
                $user_membership_badge = $membershipUser->membership_badge === 1;
            }
        }

        $galleryImageIds = !empty($listing->gallery_images) ? explode('|', $listing->gallery_images) : [];

        $galleryImagesUrls = array_map(function ($imgId) {
            return get_image_url_id_wise($imgId);
        }, $galleryImageIds);

        $listingData = array_merge($listing->toArray(), [
            'image' => get_attachment_url_by_ids($listing->image),
            'gallery_images' => $galleryImagesUrls,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Listing details fetched successfully',
            'data' => [
                'listing' => $listingData,
                'related_listings' => $related_listings,
                'user_total_listings' => $user_total_listings,
                'report_reasons' => $report_reasons,
                'membership' => [
                    'business_hour' => $user_business_hour,
                    'enquiry_form' => $user_enquiry_form,
                    'membership_badge' => $user_membership_badge,
                ]
            ]
        ], 200);
    }

    public function religion()
    {
        $brands = Brand::all(); 

        return response()->json([
            'success' => true,
            'data' => $brands
        ], 200);
    }
}
