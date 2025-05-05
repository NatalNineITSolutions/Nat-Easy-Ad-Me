<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\SendPayoutNotification;
use App\Mail\PayoutNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UsersBV;
use App\Models\IncomePayoutManage;
use Carbon\Carbon;
use App\Models\UserPayoutDetail;

class PayoutController extends Controller
{
    /**
     * Display the payout settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $latestPayout = IncomePayoutManage::latest()->first();
        $previousCaseOnHand = $latestPayout?->previous_case_on_hand ?? 0;
        $currentDayBV = UsersBV::whereDate('created_at', Carbon::today())->sum('bv_points');
        $currentDayMatchingPairs = $latestPayout?->matching_pairs ?? 1; // Ensure at least 1 to prevent division by zero

        $maxAllowed = ($currentDayMatchingPairs > 0)
            ? floor(($previousCaseOnHand + $currentDayBV) / $currentDayMatchingPairs)
            : 0;

        $payoutSettings = [
            'payout_method' => get_static_option('payout_method'),
            'payout_value' => get_static_option('payout_value'),
            'payment_type' => get_static_option('payment_type'),
            'referral_value' => get_static_option('referral_value'),
            'referral_percentage' => get_static_option('referral_percentage'),
            'bp_value' => get_static_option('bp_value'),
            'sealing_limitation' => get_static_option('sealing_limitation'),
            'bv_flush_time' => get_static_option('bv_flush_time'),
            'tds_value' => get_static_option('tds_value'),
            'service_charge' => get_static_option('service_charge'),
            'maximum_one_pair_income' => get_static_option('maximum_one_pair_income'),
        ];

        return view('backend.pages.payout-manage.payout-settings', compact(
            'payoutSettings',
            'previousCaseOnHand',
            'currentDayBV',
            'currentDayMatchingPairs',
            'maxAllowed'
        ));
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
            'bp_value' => 'required|numeric|min:0',
            'sealing_limitation' => 'required|numeric|min:0',
            'bv_flush_time' => 'required|date_format:H:i',
            'tds_value' => 'required|numeric|min:0',
            'service_charge' => 'required|numeric|min:0',
            'maximum_one_pair_income' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        set_static_option('payout_method', $request->input('payout_method'));
        set_static_option('payout_value', $request->input('payout_value'));
        set_static_option('payment_type', $request->input('payment_type'));
        set_static_option('referral_value', $request->input('referral_value'));
        set_static_option('referral_percentage', $request->input('referral_percentage'));
        set_static_option('bp_value', $request->input('bp_value'));
        set_static_option('sealing_limitation', $request->input('sealing_limitation'));
        set_static_option('bv_flush_time', $request->input('bv_flush_time'));
        set_static_option('tds_value', $request->input('tds_value'));
        set_static_option('service_charge', $request->input('service_charge'));
        set_static_option('maximum_one_pair_income', $request->input('maximum_one_pair_income'));

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
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('user_payout_details');
            })
            ->select('id', 'first_name', 'last_name', 'partner_id')
            ->with('descendants')
            ->get()
            ->map(function ($user) use ($payoutMethod, $payoutValue, $selectedDate) {
                $user->total_referrals = $this->countTotalReferrals($user);

                $payoutDetail = UserPayoutDetail::when($selectedDate, function ($query) use ($selectedDate) {
                    return $query->whereDate('created_at', $selectedDate);
                })->where('user_id', $user->id)->first();

                $user->payout_date = $payoutDetail ? $payoutDetail->created_at : null;
                $leftBv = $payoutDetail ? $payoutDetail->left_bv : 0;
                $rightBv = $payoutDetail ? $payoutDetail->right_bv : 0;

                $user->bv_points = $leftBv + $rightBv;
                $user->net_amount = $payoutDetail ? $payoutDetail->net_amount : 0;

                return $user;
            })
            ->when($selectedDate, function ($collection) {
                return $collection->filter(function ($user) {
                    return $user->bv_points > 0;
                });
            });

        $cashOnHand = DB::table('income_payout_manage')->value('balance_case_on_hand');

        // $canPayout = $this->isPayoutButtonEnabled();

        return view('backend.pages.payout-manage.payout-listing', compact(
            'users',
            'selectedDate',
            'cashOnHand',
        ));
    }

    private function isPayoutButtonEnabled(): bool
    {
        $paymentType = get_static_option('payment_type');

        $lastPayoutDate = DB::table('user_payout_details')
            ->latest('created_at')
            ->value('created_at');

        if (!$lastPayoutDate) {
            return true;
        }

        $nextEligibleDate = match ($paymentType) {
            'day' => Carbon::parse($lastPayoutDate)->addDay(),
            'week' => Carbon::parse($lastPayoutDate)->addWeek(),
            'month' => Carbon::parse($lastPayoutDate)->addMonth(),
            default => null,
        };

        return $nextEligibleDate && now()->gte($nextEligibleDate);
    }

    private function countTotalReferrals(User $user)
    {
        $count = $user->children()->count();

        foreach ($user->children as $child) {
            $count += $this->countTotalReferrals($child);
        }

        return $count;
    }

    public function incomepayoutmanage()
    {
        $latestPayout = IncomePayoutManage::latest()->first();

        $previousCaseOnHand = $latestPayout?->previous_case_on_hand ?? 0;
        $currentDayBV = UsersBV::whereDate('created_at', Carbon::today())->sum('bv_points');
        $totalBV = $previousCaseOnHand + $currentDayBV;

        $pairIncome = get_static_option('maximum_one_pair_income') ?? 250;
        $maximumDailyCeiling = get_static_option('sealing_limitation') ?? 10;
        $maximumPairIncomeLimit = get_static_option('maximum_pair_income') ?? PHP_INT_MAX;

        $currentDayMatchingPairs = $latestPayout?->matching_pairs ?? 0;

        $totalOutPutAmount = $currentDayMatchingPairs * $pairIncome;

        if ($totalOutPutAmount > $maximumPairIncomeLimit) {
            $totalOutPutAmount = $maximumPairIncomeLimit;
        }

        $balanceCaseOnHand = $totalBV - $totalOutPutAmount;

        return view('backend.pages.payout-manage.income-payout-manage', compact(
            'previousCaseOnHand',
            'currentDayBV',
            'totalBV',
            'currentDayMatchingPairs',
            'maximumDailyCeiling',
            'pairIncome',
            'totalOutPutAmount',
            'balanceCaseOnHand',
            'maximumPairIncomeLimit'
        ));
    }

    public function updateMaximumPairIncome(Request $request)
    {
        $request->validate([
            'maximum_one_pair_income' => 'required|numeric|min:0',
        ]);

        $latestPayout = IncomePayoutManage::latest()->first();
        $previousCaseOnHand = $latestPayout?->previous_case_on_hand ?? 0;
        $currentDayBV = UsersBV::whereDate('created_at', Carbon::today())->sum('bv_points');
        $totalBV = $previousCaseOnHand + $currentDayBV;
        $currentDayMatchingPairs = $latestPayout?->matching_pairs ?? 0;

        // Block if no pairs available
        if ($currentDayMatchingPairs == 0) {
            return back()->with('error', 'No matching pairs found for today. Please check before updating.');
        }

        // Calculate max allowed income
        $maxAllowed = floor($totalBV / $currentDayMatchingPairs);
        $submittedPairIncome = $request->maximum_one_pair_income;

        if ($submittedPairIncome > $maxAllowed) {
            return back()
                ->with('error', 'Entered value is too high! The maximum allowed value is ' . $maxAllowed . '. Please enter a value within this limit.')
                ->withInput()
                ->with('maxAllowed', $maxAllowed);
        }

        update_static_option('maximum_one_pair_income', $submittedPairIncome);
        return back()->with('success', 'Maximum Pair Income updated successfully!');
    }

    public function processPayout(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payout_detail_id' => 'required|exists:user_payout_details,id'
        ]);

        Log::info('Payout processing initiated', [
            'user_id' => $validated['user_id'],
            'payout_detail_id' => $validated['payout_detail_id']
        ]);

        $user = User::find($validated['user_id']);
        $payoutDetail = UserPayoutDetail::find($validated['payout_detail_id']);

        if (!$user || !$payoutDetail) {
            Log::error('User or PayoutDetail not found', [
                'user' => $user,
                'payoutDetail' => $payoutDetail
            ]);
            return redirect()->back()->with('error', 'User or Payout details not found.');
        }

        // Update payout status
        $updated = $payoutDetail->update(['status' => 'processed']);

        if (!$updated) {
            Log::error('Failed to update payout status', ['payoutDetail' => $payoutDetail]);
            return redirect()->back()->with('error', 'Failed to update payout status.');
        }

        Log::info('Dispatching SendPayoutNotification job', [
            'user_email' => $user->email,
            'payout_amount' => $payoutDetail->net_amount
        ]);

        try {
            dispatch(new SendPayoutNotification($user, $payoutDetail));
            Log::info('SendPayoutNotification job dispatched successfully');
        } catch (\Exception $e) {
            Log::error('Failed to dispatch SendPayoutNotification job', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to queue payout notification.');
        }

        return redirect()->back()->with('success', 'Payout processed successfully. Notification sent to user.');
    }
}