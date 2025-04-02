<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Models\Backend\SubCategory;
use App\Models\Backend\ChildCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\AdminNotification;
use Modules\Membership\app\Models\UserMembership;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Backend\Listing;
use App\Models\Backend\MediaUpload;
use App\Models\Frontend\ListingAttribute;
use Modules\CountryManage\app\Models\Country;
use App\Models\Backend\ListingTag;

class ListingApiController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'icon', 'image']);

        // Map each category to include the attachment URL for image.
        $categories = $categories->map(function ($category) {
            $category->image = get_attachment_url_by_ids($category->image);
            return $category;
        });

        return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ]);
    }


    public function getSubcategories(Request $request)
    {
        $subcategories = SubCategory::where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'category_id']);

        return response()->json([
            'success' => true,
            'message' => 'Subcategories retrieved successfully',
            'data' => $subcategories
        ]);
    }

    public function getChildcategories(Request $request)
    {
        $childcategories = ChildCategory::where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'sub_category_id']);

        return response()->json([
            'success' => true,
            'message' => 'Child categories retrieved successfully',
            'data' => $childcategories
        ]);
    }

    public function addListing(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        $validatedData = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|max:191',
            'description' => 'required|min:150',
            'slug' => 'required|max:255|unique:listings',
            'price' => $request->category_id == 54 ? 'nullable|numeric' : 'required|numeric',
            'qualification' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
            'experience' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
            'salary' => $request->category_id == 54 ? 'required|numeric' : 'nullable|numeric',
            'job_location' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
            'image' => 'nullable',
            'gallery_images' => 'nullable|string',
            'video_url' => 'nullable|string',
            'country_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'brand_id' => 'nullable|integer',
            'sub_category_id' => 'nullable|integer',
            'child_category_id' => 'nullable|integer',
            'negotiable' => 'nullable|boolean',
            'condition' => 'nullable|string',
            'authenticity' => 'nullable|string',
            'phone' => 'nullable|string',
            'phone_hidden' => 'nullable|boolean',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'attributes_title' => 'nullable|array',
            'attributes_description' => 'nullable|array',
        ]);

        // Handle image upload if present
        $imageId = null;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $file = $request->file('image');
            $path = $file->store('media_uploads', 'public');

            $media = MediaUpload::create([
                'user_id' => $user->id,
                'path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'type' => 'image', // Set the required type field
                'title' => $file->getClientOriginalName(),
                'alt' => '',
                'dimensions' => getimagesize($file->getPathname()) ? implode('x', getimagesize($file->getPathname())) : null,
            ]);

            $imageId = $media->id;
        } elseif ($request->filled('image')) {
            $request->validate([
                'image' => 'integer|exists:media_uploads,id'
            ]);
            $imageId = $request->image;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image is required'
            ], 422);
        }

        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $user_membership = UserMembership::where('user_id', $user->id)->first();

            if (!$user_membership || $user_membership->status === 0 || $user_membership->payment_status == 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your membership is inactive or expired. Please subscribe to a plan before creating listings.'
                ], 403);
            }

            if ($user_membership->listing_limit === 0 || $user_membership->expire_date <= Carbon::now()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your membership listing limit is over or expired.'
                ], 403);
            }

            // Check gallery images limit
            if ($request->filled('gallery_images')) {
                $gallery_images = explode('|', $request->gallery_images);
                if (count($gallery_images) > $user_membership->initial_gallery_images) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have exceeded the maximum number of gallery images allowed by your membership package.'
                    ], 403);
                }
            }

            // Check featured listing
            if ($request->is_featured && $user_membership->initial_featured_listing != 0 && $user_membership->featured_listing === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded the maximum number of featured listings allowed by your membership package.'
                ], 403);
            }
        }

        $status = get_static_option('listing_create_status_settings') == 'approved' ? 1 : 0;

        $listing = new Listing();
        $listing->user_id = $user->id;
        $listing->category_id = $validatedData['category_id'];
        $listing->sub_category_id = $request->sub_category_id;
        $listing->child_category_id = $request->child_category_id;
        $listing->country_id = $request->country_id;
        $listing->state_id = $request->state_id;
        $listing->city_id = $request->city_id;
        $listing->brand_id = $request->brand_id;
        $listing->title = $validatedData['title'];
        $listing->slug = Str::slug($validatedData['slug']);
        $listing->description = $validatedData['description'];
        $listing->price = $validatedData['category_id'] == 54 ? null : $validatedData['price'];
        $listing->negotiable = $request->negotiable ?? 0;
        $listing->condition = $request->condition;
        $listing->authenticity = $request->authenticity;
        $listing->phone = $request->phone;
        $listing->phone_hidden = $request->phone_hidden ?? 0;
        $listing->image = $imageId;
        $listing->gallery_images = $request->gallery_images;
        $listing->video_url = $request->video_url ? getYoutubeEmbedUrl($request->video_url) : null;
        $listing->address = $request->address;
        $listing->lat = $request->latitude;
        $listing->lon = $request->longitude;
        $listing->is_featured = $request->is_featured ?? 0;
        $listing->status = $status;

        if ($validatedData['category_id'] == 54) {
            $listing->qualification = $validatedData['qualification'];
            $listing->experience = $validatedData['experience'];
            $listing->expected_salary = $validatedData['salary'];
            $listing->job_location = $validatedData['job_location'];
        }

        $listing->save();

        $responseData = [
            'success' => true,
            'message' => 'Listing added successfully',
            'data' => [
                'listing' => $listing,
                'image_url' => get_attachment_url_by_ids($imageId),
            ]
        ];

        // Handle tags
        if ($request->filled('tags')) {
            foreach ($request->tags as $tagId) {
                ListingTag::create([
                    'listing_id' => $listing->id,
                    'tag_id' => $tagId,
                ]);
            }
        }

        // Handle attributes
        if ($request->filled('attributes_title')) {
            foreach ($request->input('attributes_title') as $index => $title) {
                $description = $request->input('attributes_description')[$index] ?? null;
                if (!empty($title)) {
                    ListingAttribute::create([
                        'listing_id' => $listing->id,
                        'title' => strip_tags($title),
                        'description' => strip_tags($description),
                    ]);
                }
            }
        }

        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            UserMembership::where('user_id', $user->id)->decrement('listing_limit');

            if ($request->is_featured && $user_membership->initial_featured_listing != 0) {
                UserMembership::where('user_id', $user->id)->decrement('featured_listing');
            }
        }

        AdminNotification::create([
            'identity' => $listing->id,
            'user_id' => $user->id,
            'type' => 'Create Listing',
            'message' => 'A new listing has been created'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Listing added successfully',
            'data' => $listing
        ], 201);
    }

    public function filterListings(Request $request)
    {
        try {
            // Get all input parameters
            $input = $request->all();
            
            // Initialize listing query
            $listing_query = Listing::query()->where("status", 1);
            
            // Apply filters based on input parameters
            
            // Text search
            if (!empty($input['q']) || !empty($input['home_search'])) {
                $search_text = $input['home_search'] ?? $input['q'];
                $listing_query->where(function ($query) use ($search_text) {
                    $query->where("title", "LIKE", "%" . $search_text . "%")
                        ->orWhere("description", "LIKE", "%" . $search_text . "%");
                });
            }
            
            // Location filters
            if (!empty($input['latitude']) && !empty($input['longitude'])) {
                $distance_radius_km = $input['distance_kilometers_value'] ?? 50;
                $radius = $distance_radius_km == 0 ? 50 : $distance_radius_km;
                
                $listing_query->selectRaw(
                    "listings.*,
                    (6371 * acos(
                        cos(radians(?)) * cos(radians(listings.lat)) * cos(radians(listings.lon) - radians(?)) +
                        sin(radians(?)) * sin(radians(listings.lat))
                    )) AS distance",
                    [$input['latitude'], $input['longitude'], $input['latitude']]
                )
                ->havingRaw('distance <= ?', [$radius])
                ->orderBy('distance', 'asc');
            }
            
            // Price range filter
            if (!empty($input['price_range_value'])) {
                $priceRange = explode(',', $input['price_range_value']);
                if (count($priceRange) === 2) {
                    $listing_query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
                }
            }
            
            // Country filter
            if (!empty($input['country'])) {
                $listings_country = Country::find($input['country']);
                if ($listings_country) {
                    $listings_country_ids = $listings_country->states->pluck("id")->toArray();
                    $listing_query->whereIn("state_id", $listings_country_ids);
                }
            }
            
            // State filter
            if (!empty($input['state'])) {
                $listing_query->where("state_id", $input['state']);
            }
            
            // City filter
            if (!empty($input['city'])) {
                $listing_query->where("city_id", $input['city']);
            }
            
            // Category filters
            if (!empty($input['cat'])) {
                $listing_query->where("category_id", $input['cat']);
            }
            
            if (!empty($input['subcat'])) {
                $listing_query->where("sub_category_id", $input['subcat']);
            }
            
            if (!empty($input['child_cat'])) {
                $listing_query->where("child_category_id", $input['child_cat']);
            }
            
            // Tag filter
            if (!empty($input['tag_id'])) {
                $tagIds = is_array($input['tag_id']) ? $input['tag_id'] : [$input['tag_id']];
                $listing_tag_wise_ids = ListingTag::whereIn('tag_id', $tagIds)->pluck('listing_id');
                $listing_query->whereIn("id", $listing_tag_wise_ids);
            }
            
            // Rating filter
            if (!empty($input['rating'])) {
                $rating = (int) $input['rating'];
                $listing_query->whereHas("reviews", function ($q) use ($rating) {
                    $q->groupBy("reviews.id")
                        ->havingRaw("AVG(reviews.rating) >= ?", [$rating])
                        ->havingRaw("AVG(reviews.rating) < ?", [$rating + 1]);
                });
            }
            
            // Sort by
            if (!empty($input['sortby'])) {
                switch ($input['sortby']) {
                    case "latest_listing":
                        $listing_query->orderBy("id", "Desc");
                        break;
                    case "lowest_price":
                        $listing_query->orderBy("price", "Asc");
                        break;
                    case "highest_price":
                        $listing_query->orderBy("price", "Desc");
                        break;
                }
            }
            
            // Listing type preferences
            if (!empty($input['listing_type_preferences'])) {
                switch ($input['listing_type_preferences']) {
                    case "featured":
                        $listing_query->where('is_featured', 1);
                        break;
                    case "top_listing":
                        $listing_query->orderBy('view', 'desc');
                        break;
                }
            }
            
            // Listing condition
            if (!empty($input['listing_condition'])) {
                $listing_query->where('condition', $input['listing_condition']);
            }
            
            // Date posted
            if (!empty($input['date_posted_listing'])) {
                switch ($input['date_posted_listing']) {
                    case "yesterday":
                        $listing_query->whereDate('published_at', now()->subDays(1));
                        break;
                    case "last_week":
                        $listing_query->whereBetween('published_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case "today":
                        $listing_query->whereDate('published_at', today());
                        break;
                }
            }
            
            // Pagination
            $perPage = $input['items'] ?? 10; // Default to 10 items per page
            $all_listings = $listing_query->where('status', 1)
                ->where('is_published', 1)
                ->paginate($perPage);
            
            // Format listings for response
            $formatted_listings = $all_listings->map(function ($listing) {
                return [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'slug' => $listing->slug,
                    'description' => $listing->description,
                    'price' => $listing->price,
                    'price_formatted' => custom_amount_with_currency_symbol($listing->price),
                    'image_url' => render_image_markup_by_attachment_id($listing->image),
                    'is_featured' => $listing->is_featured,
                    'published_at' => $listing->published_at,
                    'published_at_formatted' => $listing->published_at ? \Carbon\Carbon::parse($listing->published_at)->format('j M Y') : null,
                    'condition' => $listing->condition,
                    'view_count' => $listing->view,
                    'category' => $listing->category->name ?? null,
                    'sub_category' => $listing->subCategory->name ?? null,
                    'child_category' => $listing->childCategory->name ?? null,
                    'country' => $listing->country->country ?? null,
                    'state' => $listing->state->state ?? null,
                    'city' => $listing->city->city ?? null,
                    'latitude' => $listing->lat,
                    'longitude' => $listing->lon,
                    'rating' => $listing->reviews->avg('rating') ?? 0,
                    'review_count' => $listing->reviews->count(),
                    'details_url' => route("frontend.listing.details", $listing->slug),
                ];
            });
            
            // Get filter options
            $countries = Country::where('status', 1)->select('id', 'country')->get();
            $categories = Category::where('status', 1)->select('id', 'name')->get();
            
            // Get states and cities based on country if provided
            $states = [];
            $cities = [];
            $sub_categories = [];
            $child_categories = [];
            
            if (!empty($input['country'])) {
                $states = State::where('status', 1)
                    ->where('country_id', $input['country'])
                    ->select('id', 'state')
                    ->get();
            }
            
            if (!empty($input['state'])) {
                $cities = City::where('status', 1)
                    ->where('state_id', $input['state'])
                    ->select('id', 'city')
                    ->get();
            }
            
            if (!empty($input['cat'])) {
                $sub_categories = SubCategory::where('status', 1)
                    ->where('category_id', $input['cat'])
                    ->select('id', 'name')
                    ->get();
            }
            
            if (!empty($input['subcat'])) {
                $child_categories = ChildCategory::where('status', 1)
                    ->where('sub_category_id', $input['subcat'])
                    ->select('id', 'name')
                    ->get();
            }
            
            // Prepare response
            $response = [
                'success' => true,
                'message' => 'Listings retrieved successfully',
                'data' => [
                    'listings' => $formatted_listings,
                    'pagination' => [
                        'total' => $all_listings->total(),
                        'per_page' => $all_listings->perPage(),
                        'current_page' => $all_listings->currentPage(),
                        'last_page' => $all_listings->lastPage(),
                        'from' => $all_listings->firstItem(),
                        'to' => $all_listings->lastItem(),
                    ],
                    'filter_options' => [
                        'countries' => $countries,
                        'states' => $states,
                        'cities' => $cities,
                        'categories' => $categories,
                        'sub_categories' => $sub_categories,
                        'child_categories' => $child_categories,
                        'rating_stars' => [
                            "1" => "One Star",
                            "2" => "Two Star",
                            "3" => "Three Star",
                            "4" => "Four Star",
                            "5" => "Five Star",
                        ],
                        'sortby_options' => [
                            "latest_listing" => "Latest listing",
                            "lowest_price" => "Lowest Price",
                            "highest_price" => "Highest Price",
                        ],
                        'date_posted_options' => [
                            "today" => "Today",
                            "yesterday" => "Yesterday",
                            "last_week" => "Last Week",
                        ],
                        'listing_condition_options' => [
                            "new" => "New",
                            "used" => "Used",
                        ],
                        'listing_type_options' => [
                            "featured" => "Featured",
                            "top_listing" => "Top Listing",
                        ],
                    ],
                    'current_filters' => $input,
                ],
            ];
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve listings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

