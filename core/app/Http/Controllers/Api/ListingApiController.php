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

class ListingApiController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::where('status', 1)
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'slug', 'icon']);

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
}
