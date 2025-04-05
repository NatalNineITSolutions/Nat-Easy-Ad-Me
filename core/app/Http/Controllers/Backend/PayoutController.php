<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsersBV;

class PayoutController extends Controller
{
    /**
     * Display the payout settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $payoutSettings = [
            'payout_method' => get_static_option('payout_method'),
            'payout_value' => get_static_option('payout_value'),
            'payment_type' => get_static_option('payment_type'),
            'referral_value' => get_static_option('referral_value'),
            'referral_percentage' => get_static_option('referral_percentage'),
            'maximum_referrals' => get_static_option('maximum_referrals'),
            'bp_value' => get_static_option('bp_value'),
        ];

        return view('backend.pages.payout-manage.payout-settings', compact('payoutSettings'));
    }

    /**
     * Update the payout settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payout_method' => 'required|string|max:255',
            'payout_value' => 'required|numeric',
            'payment_type' => 'required|string|max:255',
            'referral_value' => 'required|numeric|min:0',
            'referral_percentage' => 'nullable|numeric|between:0,100',
            'maximum_referrals' => 'required|numeric|min:0',
            'bp_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        set_static_option('payout_method', $request->input('payout_method'));
        set_static_option('payout_value', $request->input('payout_value'));
        set_static_option('payment_type', $request->input('payment_type'));
        set_static_option('referral_value', $request->input('referral_value'));
        set_static_option('referral_percentage', $request->input('referral_percentage'));
        set_static_option('maximum_referrals', $request->input('maximum_referrals'));
        set_static_option('bp_value', $request->input('bp_value'));

        return redirect()->route('payout.settings')->with('success', __('Payout settings updated successfully!'));
    }

    public function userBvReferrals(Request $request)
    {
        $payoutMethod = get_static_option('payout_method');
        $payoutValue = get_static_option('payout_value');
        $selectedDate = $request->input('filter_date', null);

        $eligibleParents = User::select('parent_id')
            ->groupBy('parent_id')
            ->havingRaw('COUNT(CASE WHEN position = "left" THEN 1 END) > 0')
            ->havingRaw('COUNT(CASE WHEN position = "right" THEN 1 END) > 0')
            ->pluck('parent_id');

        $users = User::whereIn('id', $eligibleParents)
            ->select('id', 'first_name', 'last_name', 'partner_id')
            ->with('descendants') 
            ->get()
            ->map(function ($user) use ($payoutMethod, $payoutValue, $selectedDate) {
                $user->total_referrals = $this->countTotalReferrals($user);

                $bvQuery = UsersBv::where('user_id', $user->id);

                if ($selectedDate) {
                    $bvQuery->whereDate('upgrade_time', $selectedDate);
                }

                $user->bv_points = $bvQuery->sum('bv_points');

                if ($payoutMethod === 'amount') {
                    $user->payout = $user->bv_points * $payoutValue;
                } else {
                    $user->payout = 0;
                }

                return $user;
            })
            ->when($selectedDate, function ($collection) {
                return $collection->filter(function ($user) {
                    return $user->bv_points > 0;
                });
            });

        return view('backend.pages.payout-manage.payout-listing', compact('users', 'selectedDate'));
    }

    /**
     * Recursively count all descendants of a user
     */
    private function countTotalReferrals(User $user)
    {
        $count = $user->children()->count();

        foreach ($user->children as $child) {
            $count += $this->countTotalReferrals($child);
        }

        return $count;
    }
}