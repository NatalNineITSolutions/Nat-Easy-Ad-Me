<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\ChildCategory;
use App\Models\Backend\Listing;
use App\Models\Backend\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\JobDetail;
use App\Models\Backend\ReportReason;
use App\Models\Backend\Advertisement;
use App\Helpers\SanitizeInput;

class CategoryWiseListingController extends Controller
{

    public function showListingsByCategory($slug = null)
    {
        $category = Category::where('slug', $slug)->first();

        if (empty($category)) {
            return redirect_404_page();
        }

        $subcategory_under_category = Subcategory::where('category_id', $category->id)->orderBy('name', 'asc')->take(20)->get()->transform(function ($item) {
            $item->total_listings = Listing::where('sub_category_id', $item->id)->count();
            return $item;
        });

        $all_listings = collect([]);
        $listings_query = Listing::query();
        $listings_query->with('user');

        $memberIds = [0];
        // get all users ids from the users table according to listing table datas
        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $memberIds = Listing::query()->select('listings.user_id')
                ->join('user_memberships', 'user_memberships.user_id', '=', 'listings.user_id')
                ->whereNot('listings.user_id', 0)
                ->where('user_memberships.expire_date', '>=', date('Y-m-d'))
                ->distinct()
                ->pluck('user_id')->push(0)->toArray(); // this gives us the user ids
        }

        if (!is_null($category)) {
            $all_listings = $listings_query->where(function ($query) use ($memberIds) {
                return $query->whereIn('listings.user_id', $memberIds)
                    ->orWhereNotNull('admin_id');
            })
                ->where(['category_id' => $category->id, 'status' => 1, 'is_published' => 1])
                ->paginate(10);
        }

        return view('frontend.pages.listings.category.category-wise-listings', compact(
            'all_listings',
            'category',
            'subcategory_under_category'
        ));
    }

    //sub category wise services
    public function showListingsBySubCategory($slug = null)
    {
        // Handle job-seekers as a special case
        if ($slug === 'job-seekers') {
            return $this->showJobSeekers($slug);
        }

        $subcategory = SubCategory::with('category')->where('slug', $slug)->first();

        if (empty($subcategory)) {
            return redirect_404_page();
        }

        $child_category_under_category = ChildCategory::where('sub_category_id', $subcategory->id)
            ->orderBy('name', 'asc')
            ->take(20)
            ->get()
            ->transform(function ($item) {
                $item->total_listings = Listing::where('child_category_id', $item->id)->count();
                return $item;
            });

        $all_listings = collect([]);
        $listing_query = Listing::query();
        $listing_query->with('user');

        $memberIds = [0];
        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $memberIds = Listing::query()
                ->select('listings.user_id')
                ->join('user_memberships', 'user_memberships.user_id', '=', 'listings.user_id')
                ->whereNot('listings.user_id', 0)
                ->where('user_memberships.expire_date', '>=', date('Y-m-d'))
                ->distinct()
                ->pluck('user_id')
                ->push(0)
                ->toArray();
        }

        if (!is_null($subcategory)) {
            $all_listings = $listing_query
                ->where(function ($query) use ($memberIds) {
                    return $query->whereIn('listings.user_id', $memberIds)
                        ->orWhereNotNull('admin_id');
                })
                ->where([
                    'sub_category_id' => $subcategory->id,
                    'status' => 1,
                    'is_published' => 1
                ])
                ->paginate(12);
        }

        return view('frontend.pages.listings.category.sub-category-wise-listings', compact(
            'all_listings',
            'subcategory',
            'child_category_under_category'
        ));
    }

    protected function showJobSeekers($slug)
    {
        $memberIds = [0];

        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $memberIds = \DB::table('user_memberships')
                ->where('expire_date', '>=', date('Y-m-d'))
                ->pluck('user_id')
                ->push(0)
                ->toArray();
        }

        // Get job seeker listings directly from job_details
        $jobSeekerListings = JobDetail::with('user')
            ->where('category_id', 54)
            ->where('sub_category_id', 107)
            ->whereIn('user_id', $memberIds)
            ->paginate(12);
        \Log::info('Fetched Job Seeker Listings:', ['count' => $jobSeekerListings->count()]);

        $subcategory = SubCategory::with('category')->where('slug', $slug)->first();

        $child_category_under_category = ChildCategory::where('sub_category_id', $subcategory->id)
            ->orderBy('name', 'asc')
            ->take(20)
            ->get()
            ->transform(function ($item) {
                $item->total_listings = JobDetail::where('child_category_id', $item->id)->count();
                return $item;
            });

        return view('job-seekers.index', [
            'listings' => $jobSeekerListings,
            'subcategory' => $subcategory,
            'child_category_under_category' => $child_category_under_category
        ]);
    }

    // public function showListingsByChildCategory($slug = null)
    // {
    //     $child_category = ChildCategory::with('category', 'subcategory')->where('slug', $slug)->first();

    //     if (empty($child_category)) {
    //         return redirect_404_page();
    //     }

    //     $all_listings = collect([]);
    //     $listing_query = Listing::query();
    //     $listing_query->with('user');

    //     $memberIds = [0];
    //     // get all users ids from the users table according to listing table datas
    //     if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
    //         $memberIds = Listing::query()->select('listings.user_id')
    //             ->join('user_memberships', 'user_memberships.user_id', '=', 'listings.user_id')
    //             ->whereNot('listings.user_id', 0)
    //             ->where('user_memberships.expire_date', '>=', date('Y-m-d'))
    //             ->distinct()
    //             ->pluck('user_id')->push(0)->toArray(); // this gives us the user ids
    //     }

    //     if (!is_null($child_category)) {
    //         $all_listings = $listing_query->where(function ($query) use ($memberIds) {
    //             return $query->whereIn('listings.user_id', $memberIds)
    //                 ->orWhereNotNull('admin_id');
    //         })
    //             ->where(['child_category_id' => $child_category->id, 'status' => 1, 'is_published' => 1])
    //             ->paginate(12);
    //     }

    //     return view('frontend.pages.listings.category.child-category-wise-listings', compact('all_listings', 'child_category'));
    // }

    public function showListingsByChildCategory($slug = null)
    {
        $child_category = ChildCategory::with('category', 'subcategory')
            ->where('slug', $slug)
            ->first();

        if (empty($child_category)) {
            return redirect_404_page();
        }

        $all_listings = collect([]);
        $listing_query = Listing::with('user');

        // Membership filter (same as before)
        $memberIds = [0];
        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $memberIds = Listing::query()
                ->select('listings.user_id')
                ->join('user_memberships', 'user_memberships.user_id', '=', 'listings.user_id')
                ->whereNot('listings.user_id', 0)
                ->where('user_memberships.expire_date', '>=', date('Y-m-d'))
                ->distinct()
                ->pluck('user_id')
                ->push(0)
                ->toArray();
        }

        // If the *parent* subcategory slug is job-seekers, pull from JobDetail instead
        if (optional($child_category->subcategory)->slug === 'job-seekers') {
            $listings = JobDetail::with('user')
                ->where([
                    'child_category_id' => $child_category->id
                ])
                ->paginate(12);

            return view('job-seekers.child-category-listing', compact(
                'listings',
                'child_category'
            ));
        } else {
            $all_listings = $listing_query
                ->where(function ($query) use ($memberIds) {
                    $query->whereIn('listings.user_id', $memberIds)
                        ->orWhereNotNull('admin_id');
                })
                ->where([
                    'child_category_id' => $child_category->id,
                    'status' => 1,
                    'is_published' => 1,
                ])
                ->paginate(12);
        }

        return view('frontend.pages.listings.category.child-category-wise-listings', compact(
            'all_listings',
            'child_category'
        ));
    }


    public function loadMoreSubCategories(Request $request)
    {
        $subcategory_under_category = SubCategory::where('category_id', $request->catId)
            ->orderBy('name', 'asc')
            ->skip($request->total)
            ->take(12)
            ->get()
            ->transform(function ($item) {
                $item->total_listing = Listing::where('sub_category_id', $item->id)->count();
                return $item;
            });
        $markup = '';
        if (!is_null($subcategory_under_category)) {
            foreach ($subcategory_under_category as $sub_cat) {
                $markup .= '<div class="col-lg-3 col-sm-6 margin-top-30 category-child">
                            <div class="single-category style-02 wow fadeInUp" data-wow-delay=".2s">
                                <div class="icon category-bg-thumb-format" ' . render_background_image_markup_by_attachment_id($sub_cat->image) . '></div>
                                <div class="category-contents">
                                    <h4 class="category-title"> <a href="' . route('frontend.show.listing.by.subcategory', $sub_cat->slug) . '">' . $sub_cat->name . '</a> </h4>
                                    <span class="category-para">  ' . sprintf(__('%s Listing'), $sub_cat->total_listing) . ' </span>
                                </div>
                            </div>
                        </div>';
            }
        }
        return response(['markup' => $markup, 'total' => $request->total + 12]);
    }

    // sub category wish service
    public function loadMoreChildCategories(Request $request)
    {
        $child_category_under_category = ChildCategory::where('sub_category_id', $request->catId)
            ->orderBy('name', 'asc')
            ->skip($request->total)
            ->take(12)
            ->get()
            ->transform(function ($item) {
                $item->total_listing = Listing::where('child_category_id', $item->id)->count();
                return $item;
            });
        $markup = '';
        if (!is_null($child_category_under_category)) {
            foreach ($child_category_under_category as $child_cat) {
                $markup .= '<div class="col-lg-3 col-sm-6 margin-top-30 category-child">
                            <div class="single-category style-02 wow fadeInUp" data-wow-delay=".2s">
                                <div class="icon category-bg-thumb-format" ' . render_background_image_markup_by_attachment_id($child_cat->image) . '></div>
                                <div class="category-contents">
                                    <h4 class="category-title"> <a href="' . route('frontend.show.listing.by.child.category', $child_cat->slug) . '">' . $child_cat->name . '</a> </h4>
                                    <span class="category-para">  ' . sprintf(__('%s Listing'), $child_cat->total_listing) . ' </span>
                                </div>
                            </div>
                        </div>';
            }
        }
        return response(['markup' => $markup, 'total' => $request->total + 12]);
    }

    public function show($id)
    {
        $listing = JobDetail::with(['user', 'user.membershipUser'])->findOrFail($id);

        if (empty($listing)) {
            return redirect_404_page();
        }
        if ($listing->is_published === 0) {
            return redirect_404_page();
        }

        $related_listings = JobDetail::where('user_id', $listing->user_id)
            ->inRandomOrder()
            ->where('id', '!=', $listing->id)
            ->take(4)
            ->get();

        if ($listing->user) {
            $user_total_listings = JobDetail::where('user_id', $listing->user->id)->count();
        } else {
            $user_total_listings = 0;
        }

        $viewToIncrement = 1;
        $listing->where('id', $listing->id)->increment('view', $viewToIncrement);

        $report_reasons = ReportReason::where('status', 1)
            ->latest()
            ->take(500)
            ->get();

        // Google ads left start
        $add_query = Advertisement::query();
        if (!empty(get_static_option('left_listing_details_page_advertisement_type'))) {
            $add_query = $add_query->where('type', get_static_option('left_listing_details_page_advertisement_type'));
        }
        if (!empty(get_static_option('left_listing_details_page_advertisement_size'))) {
            $add_query = $add_query->where('size', get_static_option('left_listing_details_page_advertisement_size'));
        }
        $add = $add_query->where('status', 1)->inRandomOrder()->first();
        $image_markup = '';
        $redirect_url = '';
        $slot = '';
        $embed_code = '';
        $add_markup = '';
        $add_id = $add->id ?? '';
        $custom_container = get_static_option('left_listing_details_page_advertisement_alignment');
        if (!empty($add)) {
            $image_markup = render_image_markup_by_attachment_id($add->image, null, 'full');
            $redirect_url = SanitizeInput::esc_url($add->redirect_url);
            $slot = $add->slot;
            $embed_code = $add->embed_code;
            if ($add->type === 'image') {
                $add_markup .= '<a href="' . $redirect_url . '">' . $image_markup . '</a>';
            } elseif ($add->type === 'google_adsense') {
                $add_markup .= $this->script_add($slot);
            } else {
                $add_markup .= '<div>' . $embed_code . '</div>';
            }
        }

        // Google ads right start
        $right_add_query = Advertisement::query();
        if (!empty(get_static_option('right_listing_details_page_advertisement_type'))) {
            $right_add_query = $right_add_query->where('type', get_static_option('right_listing_details_page_advertisement_type'));
        }
        if (!empty(get_static_option('right_listing_details_page_advertisement_size'))) {
            $right_add_query = $right_add_query->where('size', get_static_option('right_listing_details_page_advertisement_size'));
        }
        $add_right = $right_add_query->where('status', 1)->inRandomOrder()->first();

        $right_image_markup = '';
        $right_redirect_url = '';
        $right_slot = '';
        $right_embed_code = '';
        $right_add_markup = '';
        $right_add_id = $add_right->id ?? '';
        $right_custom_container = get_static_option('left_listing_details_page_advertisement_alignment');

        if (!empty($add_right)) {
            $right_image_markup = render_image_markup_by_attachment_id($add_right->image, null, 'full');
            $right_redirect_url = SanitizeInput::esc_url($add_right->redirect_url);
            $right_slot = $add_right->slot;
            $right_embed_code = $add_right->embed_code;
            if ($add_right->type === 'image') {
                $right_add_markup .= '<a href="' . $right_redirect_url . '">' . $right_image_markup . '</a>';
            } elseif ($add_right->type === 'google_adsense') {
                $right_add_markup .= $this->script_add($right_slot);
            } else {
                $right_add_markup .= '<div>' . $right_embed_code . '</div>';
            }
        }

        $user_business_hour = false;
        $user_enquiry_form = false;
        $user_membership_badge = false;

        if (moduleExists('Membership') && membershipModuleExistsAndEnable('Membership')) {
            $membershipUser = optional($listing->user)->membershipUser;
            if ($membershipUser) {
                $user_business_hour = $membershipUser->business_hour === 1;
                $user_enquiry_form = $membershipUser->enquiry_form === 1;
                $user_membership_badge = $membershipUser->membership_badge === 1;
            }
        }

        // Find the associated job seeker
        $jobSeeker = $listing->jobSeeker;

        return view('frontend.pages.listings.job-seeker-details', [
            'listing' => $listing,
            'jobSeeker' => $jobSeeker,
            'related_listings' => $related_listings,
            'user_total_listings' => $user_total_listings,
            'report_reasons' => $report_reasons,
            'user_business_hour' => $user_business_hour,
            'user_enquiry_form' => $user_enquiry_form,
            'user_membership_badge' => $user_membership_badge,
            'add_markup' => $add_markup,
            'add_id' => $add_id,
            'custom_container' => $custom_container,
            'right_add_markup' => $right_add_markup,
            'right_custom_container' => $right_custom_container,
            'right_add_id' => $right_add_id
        ]);
    }

    public function showResume($id)
    {
        $listing = JobDetail::with([
            'user',
            'user.membershipUser',
            'city',
            'state',
            'country'
        ])->findOrFail($id);

        if (empty($listing) || $listing->is_published === 0) {
            return redirect_404_page();
        }

        $listing->increment('view');

        return view('frontend.pages.listings.job-seeker-resume', [
            'listing' => $listing,
            'jobSeeker' => $listing->jobSeeker
        ]);
    }
}
