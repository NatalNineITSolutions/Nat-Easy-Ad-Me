<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Backend\AdminNotification;
use App\Models\Backend\Category;
use App\Models\Backend\ChildCategory;
use App\Models\Backend\IdentityVerification;
use App\Models\Backend\Listing;
use App\Models\Backend\ListingTag;
use App\Models\Backend\Page;
use App\Models\Backend\SubCategory;
use App\Models\Common\ListingReport;
use App\Models\Frontend\ListingAttribute;
use App\Models\Frontend\ListingFavorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Blog\app\Models\Tag;
use Modules\Brand\app\Models\Brand;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\Membership\app\Models\UserMembership;

class ListingController extends Controller
{

    public function allListing(Request $request)
    {
        $listings = Listing::where('user_id', Auth::guard('web')->user()->id)->latest()->paginate(5);
        return view('frontend.user.listings.all-listings', compact('listings'));
    }

    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)
            ->where('status', 1)
            ->get();

        return response()->json($subcategories);
    }

    public function getChildCategories(Request $request)
    {
        $childcategories = ChildCategory::where('sub_category_id', $request->sub_category_id)
            ->where('status', 1)
            ->get();

        return response()->json($childcategories);
    }

    // add listing page
    public function addListing(Request $request)
    {

        // Check Membership Status
        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $user_membership_check = UserMembership::where('user_id', Auth::guard('web')->user()->id)->first();

            // Add a null check
            if (!$user_membership_check) {
                toastr_error(__('You do not have an active membership plan. Please subscribe to a plan before creating listings.'));
                return redirect()->back();
            }

            // Check if the membership is inactive or payment is pending
            if ($user_membership_check->status === 0 || $user_membership_check->payment_status == 'pending') {
                toastr_error(__('Your membership plan is inactive. Please activate your plan before creating listings.'));
                return redirect()->back();
            }
        }

        if ($request->isMethod('post')) {
            //user Verify check
            if (get_static_option('listing_create_settings') == 'verified_user') {
                $user_identity = IdentityVerification::select('user_id', 'status')->where('user_id', Auth::guard('web')->user()->id)->first();
                $user_verified_status = $user_identity?->status ?? 0;
                if ($user_verified_status != 1) {
                    toastr_error(__('You are not verified. to add listings you must have to verify your account first'));
                    return redirect()->back();
                }
            }

            //check membership
            if (moduleExists('Membership')) {
                if (membershipModuleExistsAndEnable('Membership')) {
                    $user_membership = UserMembership::where('user_id', Auth::guard('web')->user()->id)->first();
                    // if user membership is null
                    if (is_null($user_membership)) {
                        toastr_error(__('you have to membership a package to create listings'));
                        return redirect()->back();
                    }

                    $user_total_listing_count = Listing::where('user_id', Auth::guard('web')->user()->id)->count();


                    // check user membership all listing limit
                    // if ($user_membership->listing_limit == 0 && $user_membership->expire_date <= Carbon::now()) {
                    //     session()->flash('message', __('Your Membership is expired'));
                    //     return redirect()->back();
                    // } elseif ($user_membership->listing_limit === 0) {
                    //     toastr_error(__('Your membership listing limit is over!. please renew it'));
                    //     return redirect()->back();
                    // } elseif ($user_membership->expire_date <= Carbon::now()) {
                    //     toastr_error(__('Your Membership is expired'));
                    //     return redirect()->back();
                    // 

                    // Only check listing limit
                    if ($user_membership->listing_limit === 0) {
                        toastr_error(__('Your membership listing limit is over! Please renew or upgrade your plan.'));
                        return redirect()->back();
                    }

                    // Check if the user has exceeded the allowed number of gallery images
                    $initial_gallery_images = $user_membership->initial_gallery_images;
                    $gallery_images = $request->gallery_images;
                    $gallery_images_input = explode('|', $gallery_images);
                    $gallery_images_input_count = count($gallery_images_input);

                    if ($gallery_images_input_count > $initial_gallery_images) {
                        toastr_error(__('You have exceeded the maximum number of gallery images allowed by your membership package.'));
                        return redirect()->back();
                    }

                    // Check featured listing
                    if (!empty($request->is_featured)) {
                        if ($user_membership->initial_featured_listing != 0) {
                            if ($user_membership->featured_listing === 0) {
                                toastr_error(__('You have exceeded the maximum number of featured listings allowed by your membership package.'));
                                return redirect()->back();
                            }
                        }
                    }

                }
            }

            // Validation rules
            $request->validate([
                'category_id' => 'required',
                'sub_category_id' => 'nullable|exists:sub_categories,id,category_id,' . $request->category_id,
                'child_category_id' => 'nullable|exists:child_categories,id,sub_category_id,' . $request->sub_category_id,
                'title' => 'required|max:191',
                'description' => 'required|min:20',
                'slug' => 'required|max:255|unique:listings',
                'price' => $request->category_id == 54 ? 'nullable|numeric' : 'required|numeric',
                // Job-related fields validation
                'qualification' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
                'experience' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
                'salary' => $request->category_id == 54 ? 'required|numeric' : 'nullable|numeric',
                'job_location' => $request->category_id == 54 ? 'required|string|max:255' : 'nullable|string|max:255',
            ], [
                'title.required' => __('The title field is required.'),
                'title.max' => __('The title must not exceed 191 characters.'),
                'description.required' => __('The description field is required.'),
                'description.min' => __('The description must be at least 150 characters.'),
                'slug.required' => __('The slug field is required.'),
                'slug.unique' => __('The slug has already been taken.'),
                'price.required' => __('The price field is required.'),
                'price.numeric' => __('The price must be a numeric value.'),
                'qualification.required' => __('The qualification field is required for job listings.'),
                'experience.required' => __('The experience field is required for job listings.'),
                'salary.required' => __('The expected salary field is required for job listings.'),
                'job_location.required' => __('The job location field is required for job listings.'),
            ]);

            $user = User::where('id', Auth::guard('web')->user()->id)->first();
            $slug = !empty($request->slug) ? $request->slug : $request->title;

            if (get_static_option('listing_create_status_settings') == 'approved') {
                $status = 1;
            } else {
                $status = 0;
            }

            // video url
            $video_url = null;
            if (!empty($request->video_url)) {
                $video_url = getYoutubeEmbedUrl($request->video_url);
            }

            // listing phone number
            $listing_phone = $request->country_code ?? $request->phone;

            // Create a new listing
            $listing = new Listing();
            $listing->user_id = $user->id;
            $listing->category_id = $request->category_id;
            $listing->sub_category_id = $request->sub_category_id;
            $listing->child_category_id = $request->child_category_id;
            $listing->country_id = $request->country_id;
            $listing->state_id = $request->state_id;
            $listing->city_id = $request->city_id;
            $listing->brand_id = $request->brand_id;
            $listing->title = $request->title;
            $listing->slug = Str::slug(purify_html($slug), '-', null);
            $listing->description = $request->description;
            $listing->price = $request->category_id == 54 ? null : $request->price; // Set price to null for job category
            $listing->negotiable = $request->negotiable ?? 0;
            $listing->condition = $request->condition;
            $listing->authenticity = $request->authenticity;
            $listing->phone = $listing_phone;
            $listing->phone_hidden = $request->phone_hidden ?? 0;
            $listing->image = $request->image;
            $listing->gallery_images = $request->gallery_images;
            $listing->video_url = $video_url;
            $listing->address = $request->address;
            $listing->lat = $request->latitude;
            $listing->lon = $request->longitude;
            $listing->is_featured = $request->is_featured ?? 0;
            $listing->status = $status;

            // Add job-related fields if category is job category
            if ($request->category_id == 54) {
                $listing->qualification = $request->qualification;
                $listing->experience = $request->experience;
                $listing->expected_salary = $request->salary;
                $listing->job_location = $request->job_location;
            }

            $listing->save();

            $tags_name = '';
            if (!empty($request->tags)) {
                $tags_name = Tag::whereIn('id', $request->tags)->pluck('name')->implode(', ');
            }
            $Metas = [
                'meta_title' => purify_html($request->title),
                'meta_tags' => purify_html($tags_name),
                'meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'facebook_meta_tags' => purify_html($tags_name),
                'facebook_meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'facebook_meta_image' => $request->image,
                'twitter_meta_tags' => purify_html($tags_name),
                'twitter_meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'twitter_meta_image' => $request->image,
            ];
            $listing->save();
            // Retrieve the last inserted ID
            $last_listing_id = $listing->id;

            // create Listing Attribute
            if ($request->filled('attributes_title')) {
                foreach ($request->input('attributes_title') as $index => $title) {
                    $description = $request->input('attributes_description')[$index] ?? null;
                    // Sanitize title and description
                    $sanitizedTitle = strip_tags($title);
                    $sanitizedDescription = strip_tags($description);
                    if (!is_null($title)) {
                        ListingAttribute::create([
                            'listing_id' => $last_listing_id,
                            'title' => $sanitizedTitle,
                            'description' => $sanitizedDescription,
                        ]);
                    }
                }
            }

            // create tags
            if ($request->filled('tags')) {
                foreach ($request->tags as $tagId) {
                    ListingTag::create([
                        'listing_id' => $last_listing_id,
                        'tag_id' => $tagId,
                    ]);
                }
            }

            $user_id = Auth::guard('web')->user()->id;

            // if membership system decrement listing limit
            if (moduleExists('Membership')) {
                if (membershipModuleExistsAndEnable('Membership')) {
                    // listing limit
                    UserMembership::where('user_id', $user_id)->update([
                        'listing_limit' => DB::raw(sprintf("listing_limit - %s", (int) strip_tags(1))),
                    ]);

                    // is featured listing
                    $user_membership_check = UserMembership::where('user_id', $user_id)->first();
                    if ($user_membership_check->initial_featured_listing != 0) {
                        if (!empty($request->is_featured)) {
                            UserMembership::where('user_id', $user_id)->update([
                                'featured_listing' => DB::raw(sprintf("featured_listing - %s", (int) strip_tags(1))),
                            ]);
                        }
                    }
                }
            }

            // Decrease listing limit only if it is greater than 0
            $userMembership = UserMembership::where('user_id', $user_id)->first();
            if ($userMembership && $userMembership->listing_limit > 0) {
                UserMembership::where('user_id', $user_id)->update([
                    'listing_limit' => DB::raw("GREATEST(listing_limit - 0, 0)"),
                ]);
            }

            //create listing notification to admin
            AdminNotification::create([
                'identity' => $last_listing_id,
                'user_id' => $user_id,
                'type' => 'Create Listing',
                'message' => __('A new listing has been created'),
            ]);

            // sent email to admin
            if (get_static_option('listing_create_status_settings') == 'pending') {
                try {
                    $subject = get_static_option('listing_approve_subject') ?? __('New Listing Approve Request');
                    $message = get_static_option('listing_approve_message');
                    $message = str_replace(["@listing_id"], [$last_listing_id], $message);
                    Mail::to(get_static_option('site_global_email'))->send(new BasicMail([
                        'subject' => $subject,
                        'message' => $message
                    ]));
                } catch (\Exception $e) {
                    //
                }
            }

            return redirect()->route('user.all.listing')->with(toastr_success(__('Listing Added Success')));
        }

        //check membership
        if (moduleExists('Membership')) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $user_membership = UserMembership::where('user_id', Auth::guard('web')->user()->id)->first();
                if (is_null($user_membership)) {
                    toastr_error(__('you have to membership a package to create listings'));
                    return redirect()->back();
                }
            }
        }

        $categories = Category::where('status', 1)->get();
        $sub_categories = SubCategory::where('status', 1);
        $all_countries = Country::all_countries();
        $all_states = State::all_states();
        $all_cities = City::all_cities();
        $tags = Tag::where('status', 'publish')->get();
        $user = Auth::guard('web')->user();
        $brands = Brand::where('status', 1)->get();
        $user_identity_verifications = IdentityVerification::where('user_id', $user->id)->first();

        // if membership module exits
        $membership_page_url = get_static_option('membership_plan_page') ? Page::select('slug')->find(get_static_option('membership_plan_page'))->slug : '';
        $user_featured_listing_enable = false;
        $user_listing_limit_check = false;
        if (moduleExists('Membership')) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $user_membership = UserMembership::where('user_id', $user->id)->first();
                if ($user_membership->featured_listing != 0) {
                    $user_featured_listing_enable = true;
                }
                if ($user_membership->listing_limit === 0) {
                    $user_listing_limit_check = true;
                }
            }
        }

        return view('frontend.user.listings.add-listing', compact(
            'membership_page_url',
            'user_featured_listing_enable',
            'user_listing_limit_check',
            'user',
            'brands',
            'categories',
            'sub_categories',
            'all_countries',
            'all_states',
            'all_cities',
            'tags',
            'user_identity_verifications'
        ));

    }

    // Edit listing page
    public function editListing(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            // Validation start
            $request->validate([
                'category_id' => 'required',
                'title' => 'required|max:191',
                'description' => 'required|min:20',
                'slug' => 'required|unique:listings,slug,' . $id . ',id',
                'price' => 'required|numeric',
                // Attributes Validation
                'attributes_title' => 'nullable|array',
                'attributes_title.*' => 'nullable|string|max:255',
                'attributes_description' => 'nullable|array',
                'attributes_description.*' => 'nullable|string|max:1000',
            ], [
                'title.required' => __('The title field is required.'),
                'title.max' => __('The title must not exceed 191 characters.'),
                'description.required' => __('The description field is required.'),
                'description.min' => __('The description must be at least 150 characters.'),
                'slug.required' => __('The slug field is required.'),
                'slug.unique' => __('The slug has already been taken.'),
                'price.required' => __('The price field is required.'),
                'price.numeric' => __('The price must be a numeric value.'),
            ]);
            // country, state, city
            $user = User::where('id', Auth::guard('web')->user()->id)->first();
            $slug = !empty($request->slug) ? $request->slug : $request->title;

            if (get_static_option('listing_create_status_settings') == 'approved') {
                $status = 1;
            } else {
                $status = 0;
            }

            // video url
            $video_url = null;
            if (!empty($request->video_url)) {
                $video_url = getYoutubeEmbedUrl($request->video_url);
            }

            // listing phone number
            $listing_phone = $request->country_code ?? $request->phone;

            // Edit listing
            $listing = Listing::with('listing_attributes')->findOrFail($id);
            $listing->user_id = $user->id;
            $listing->category_id = $request->category_id;
            $listing->sub_category_id = $request->sub_category_id;
            $listing->child_category_id = $request->child_category_id;
            $listing->country_id = $request->country_id;
            $listing->state_id = $request->state_id;
            $listing->city_id = $request->city_id;
            $listing->brand_id = $request->brand_id;
            $listing->title = $request->title;
            $listing->slug = Str::slug(purify_html($slug), '-', null);
            $listing->description = $request->description;
            $listing->price = $request->price;
            $listing->negotiable = $request->negotiable ?? 0;
            $listing->condition = $request->condition;
            $listing->authenticity = $request->authenticity;
            $listing->phone = $listing_phone;
            $listing->phone_hidden = $request->phone_hidden ?? 0;
            $listing->image = $request->image;
            $listing->gallery_images = $request->gallery_images;
            $listing->video_url = $video_url;
            $listing->address = $request->address;
            $listing->lat = $request->latitude;
            $listing->lon = $request->longitude;
            $listing->is_featured = $request->is_featured ?? 0;
            $listing->status = $status;


            $tags_name = '';
            if (!empty($request->tags)) {
                $tags_name = Tag::whereIn('id', $request->tags)->pluck('name')->implode(', ');
            }
            $Metas = [
                'meta_title' => purify_html($request->title),
                'meta_tags' => purify_html($tags_name),
                'meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'facebook_meta_tags' => purify_html($tags_name),
                'facebook_meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'facebook_meta_image' => $request->image,
                'twitter_meta_tags' => purify_html($tags_name),
                'twitter_meta_description' => substr(strip_tags(purify_html($request->description)), 0, 100),
                'twitter_meta_image' => $request->image,
            ];
            $listing->save();
            // Retrieve the last inserted ID
            $last_listing_id = $listing->id;

            // Edit attributes
            if ($listing->listing_attributes()->count() > 0) {
                $listing->listing_attributes()->delete();
            }
            if ($request->filled('attributes_title')) {
                foreach ($request->input('attributes_title') as $index => $title) {
                    $description = $request->input('attributes_description')[$index] ?? null;
                    $sanitizedTitle = strip_tags($title);
                    $sanitizedDescription = strip_tags($description);
                    if (!is_null($sanitizedTitle) && !empty($sanitizedTitle)) {
                        ListingAttribute::create([
                            'listing_id' => $last_listing_id,
                            'title' => $sanitizedTitle,
                            'description' => $sanitizedDescription,
                        ]);
                    }
                }
            }

            // Edit tags
            if ($request->filled('tags')) {
                $listing->tags()->detach();
                foreach ($request->tags as $tagId) {
                    ListingTag::create([
                        'listing_id' => $last_listing_id,
                        'tag_id' => $tagId,
                    ]);
                }
            }

            // send email to admin
            try {
                $message = get_static_option('service_approve_message');
                $message = str_replace(["@service_id"], [$last_listing_id], $message);
                Mail::to(get_static_option('site_global_email'))->send(new BasicMail([
                    'subject' => get_static_option('service_approve_subject') ?? __('New Listing Approve Request'),
                    'message' => $message
                ]));
            } catch (\Exception $e) {
                //
            }

            return back()->with(toastr_success(__('Listing Updated Success')));
        }


        $listing = Listing::with('listing_attributes')->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $sub_categories = SubCategory::where('status', 1)->get();
        $child_categories = ChildCategory::where('status', 1)->get();
        $all_countries = Country::all_countries();
        $all_states = State::all_states();
        $all_cities = City::all_cities();
        $brands = Brand::where('status', 1)->get();
        $tags = Tag::where('status', 'publish')->get();

        // if membership module exits
        $membership_page_url = get_static_option('membership_plan_page') ? Page::select('slug')->find(get_static_option('membership_plan_page'))->slug : '';
        $user_featured_listing_enable = false;
        $user_listing_limit_check = false;
        if (moduleExists('Membership')) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $user_membership = UserMembership::where('user_id', Auth::guard('web')->user()->id)->first();
                if (!empty($user_membership)) {
                    if ($user_membership->featured_listing != 0) {
                        $user_featured_listing_enable = true;
                    }
                    if ($user_membership->listing_limit === 0) {
                        $user_listing_limit_check = true;
                    }
                }

            }
        }

        return view('frontend.user.listings.edit-listing', compact(
            'membership_page_url',
            'user_featured_listing_enable',
            'user_listing_limit_check',
            'listing',
            'brands',
            'categories',
            'sub_categories',
            'child_categories',
            'all_countries',
            'all_states',
            'all_cities',
            'tags'
        ));
    }

    public function deleteListing($id = null)
    {
        if (Listing::find($id)) {
            ListingTag::where('listing_id', $id)->delete();
            ListingFavorite::where('listing_id', $id)->delete();
            ListingReport::where('listing_id', $id)->delete();

            // Delete the main Listing record
            Listing::find($id)->delete();

            toastr_error(__('Listing Delete Success---'));
            return redirect()->back();
        } else {
            toastr_error(__('Listing not found'));
            return redirect()->back();
        }
    }

    public function listingPublishedStatus($id)
    {
        // First check if the listing exists
        $listing = Listing::find($id);
        if (!$listing) {
            $message = __('Listing not found.');
            toastr()->error($message);
            return redirect()->back();
        }

        // Check listing approval status
        if ($listing->status === 0) {
            $message = __('This listing is not yet approved. It will be published after approval.');
            toastr()->warning($message);
            return redirect()->back();
        }

        // Toggle listing publication status
        $listing->is_published = !$listing->is_published;
        $listing->save();

        // Show appropriate message
        if ($listing->is_published) {
            // Listing is published
            $message = __('Listing has been successfully published.');
            toastr()->success($message);
        } else {
            // Listing is unpublished
            $message = __('Listing has been successfully unpublished.');
            toastr()->warning($message);
        }

        return redirect()->back();
    }


}
