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
                $query->select('user_id')
                    ->from('user_payout_details');
            })
            ->select('id', 'first_name', 'last_name', 'partner_id')
            ->with('payout_details')
            ->get()
            ->map(function ($user) use ($selectedDate) {
                $user->total_referrals = $this->countTotalReferrals($user);

                $payoutDetail = UserPayoutDetail::when($selectedDate, function ($q) use ($selectedDate) {
                    return $q->whereDate('created_at', $selectedDate);
                })
                    ->where('user_id', $user->id)
                    ->where('status', '!=', 'no_payout')      // ← filter out “no_payout” here
                    ->first();

                $user->payoutDetail = $payoutDetail;
                $user->payout_date = $payoutDetail?->created_at;
                $user->bv_points = ($payoutDetail->left_bv ?? 0) + ($payoutDetail->right_bv ?? 0);
                $user->net_amount = $payoutDetail->net_amount ?? 0;

                return $user;
            })
            // remove any users where we found no valid payoutDetail
            ->filter(fn($user) => $user->payoutDetail !== null)
            // if filtering by date, also remove zero‑BV entries
            ->when($selectedDate, fn($coll) => $coll->filter(fn($u) => $u->bv_points > 0));

        $cashOnHand = DB::table('income_payout_manage')
            ->value('balance_case_on_hand');

        $lastFlushRecord = UserPayoutDetail::where('status', 'processed')
            ->orderByDesc('updated_at')
            ->first();

        $lastPayoutAt = $lastFlushRecord
            ? $lastFlushRecord->updated_at
            : now();

        return view('backend.pages.payout-manage.payout-listing', compact(
            'users',
            'selectedDate',
            'cashOnHand',
            'lastPayoutAt',
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
            'user_id' => 'required|array|min:1',
            'user_id.*' => 'exists:users,id',
            'payout_detail_id' => 'required|array',
            'payout_detail_id.*' => 'exists:user_payout_details,id',
        ]);

        Log::info('Payout processing initiated', [
            'user_id' => $validated['user_id'],
            'payout_detail_id' => $validated['payout_detail_id']
        ]);

        // 1) get all emails for these users
        $emailsByUser = User::whereIn('id', $validated['user_id'])
            ->pluck('email', 'id');

        // 2a) sum ONLY the payouts you just validated (if you only want these payouts):
        $totalsByUser = UserPayoutDetail::whereIn('id', $validated['payout_detail_id'])
            ->groupBy('user_id')
            ->selectRaw('user_id, SUM(net_amount) as total_net')
            ->pluck('total_net', 'user_id');

        foreach ($totalsByUser as $userId => $sum) {
            $user = User::find($userId);

            // skip if something’s wrong
            if (!$user || !isset($emailsByUser[$userId])) {
                Log::warning("Skipping mail for user {$userId}");
                continue;
            }

            dispatch(new SendPayoutNotification($user, $sum));
        }



        return redirect()->back()->with('success', 'Payout processed successfully. Notification sent to user.');
    }
}