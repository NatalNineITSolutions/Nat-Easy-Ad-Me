<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Membership\app\Models\Enquiry;
use App\Models\Backend\IdentityVerification;
use App\Models\User;
use Modules\Membership\app\Models\UserMembership;

class EnquiryControllerApi extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_id' => 'required|integer',
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();


        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resumes', $filename, 'public');
            $data['resume'] = $path;
        }

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        DB::table('enquiries')->insert($data);

        return response()->json([
            'status' => 'add_success',
            'message' => 'Enquiry submitted successfully.',
        ]);
    }

    public function allEnquiriesApi()
    {
        $user = Auth::guard('sanctum')->user(); // Adjust if you're using different guard

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $all_enquiries = Enquiry::with('listing')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $all_enquiries
        ]);
    }

    public function showProfileApi()
    {
        $user = auth()->user();
        $verification = IdentityVerification::where('user_id', $user->id)->first();
        $sponsor = User::find($user->sponsor_id);

        $user_ads_posted = $user->listings()->count();
        $averageRating = $user->reviews?->avg('rating');
        $user_review_count = $user->reviews?->count();
        $age = $user->dob ? now()->diffInYears($user->dob) : null;

        // Get user memberships with joined membership details
        $userMemberships = UserMembership::with('membership')
            ->where('user_id', $user->id)
            ->get();

        $normal_membership = $userMemberships->firstWhere('membership.category', 0);
        $matrimony_membership = $userMemberships->firstWhere('membership.category', 1);

        $profile = [
            'profile_id' => $user->partner_id,
            'sponsor_id' => $sponsor?->partner_id,
            'full_name' => $user->full_name,
            'dob' => $user->dob,
            'gender' => $user->gender,
            'whatsapp_no' => $user->phone,
            'mobile_number' => $user->phone,
            'father_husband_name' => $verification->relation_name ?? null,
            'completion_percentage' => $verification ? 100 : 0,
            'email' => $user->email,
            'nominee_name' => $verification->nominee_name ?? null,
            'bank_name' => $verification->bank_name ?? null,
            'branch' => $verification->branch ?? null,
            'ifsc_code' => $verification->ifsc_code ?? null,
            'account_no' => $verification->bank_account_no ?? null,
            'account_type' => $verification->account_type ?? null,
            'image' => $user->image,
            'user_ads_posted' => $user_ads_posted,
            'average_rating' => $averageRating,
            'review_count' => $user_review_count,
            'age' => $age,
            'created_at' => $user->created_at,
            'address' => $user->address,
            'country_id' => $user->country_id,
            'state_id' => $user->state_id,
            'city_id' => $user->city_id,
            'phone' => $user->phone,
            'is_verified' => $user->email_verified_at && $user->phone_verified_at,

            // Membership info
            'normal_membership' => $normal_membership,
            'matrimony_membership' => $matrimony_membership,
        ];

        return response()->json(['success' => true, 'data' => $profile]);
    }

}
