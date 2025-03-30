<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Listing;

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
                    'price'       => $listing->category_id != 54 ? amount_with_currency_symbol($listing->price) : null,
                    'address'       => $listing->address,
                    'is_featured' =>  $listing->is_featured,
                    'created_at' =>  $listing->published_at,
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
        $items = $request->query('items', 6);
        $distance = $request->query('distance', 50);
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');

        if (!$latitude || !$longitude) {
            return response()->json([
                'success' => false,
                'message' => 'Latitude and Longitude are required',
                'data' => []
            ], 400);
        }

        $listings = Listing::where('status', 1)
            ->where('is_published', 1)
            ->selectRaw(
                "*, (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lon) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance",
                [$latitude, $longitude, $latitude]
            )
            ->havingRaw('distance <= ?', [$distance])
            ->orderBy('distance', 'asc')
            ->take($items)
            ->get()
            ->map(function ($listing) {
                return [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'description' => $listing->description,
                    'latitude' => $listing->lat,
                    'longitude' => $listing->lon,
                    'price'       => $listing->category_id != 54 ? amount_with_currency_symbol($listing->price) : null,
                    'distance' => round($listing->distance, 2) . ' km',
                    'image' => get_attachment_url_by_ids($listing->image),
                    'address'       => $listing->address,
                    'is_featured' =>  $listing->is_featured,
                    'created_at' =>  $listing->published_at,
                ];

            });

        return response()->json([
            'success' => true,
            'message' => 'Location-based listings retrieved successfully',
            'data' => $listings
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
}
