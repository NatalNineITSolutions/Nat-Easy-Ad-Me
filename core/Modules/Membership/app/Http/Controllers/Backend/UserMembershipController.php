<?php

namespace Modules\Membership\app\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;
use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Backend\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\Membership\app\Models\MembershipHistory;
use Modules\Membership\app\Models\UserMembership;
use Modules\Membership\app\Models\Membership;
use App\Models\UsersBV;

class UserMembershipController extends Controller
{
    //user memberships
    public function all_membership()
    {
        $all_memberships = UserMembership::whereHas('user')->latest()->paginate(10);
        $active_membership = UserMembership::whereHas('user')->where('status', 1)->count();
        $inactive_membership = UserMembership::whereHas('user')->where('status', 0)->count();
        $manual_membership = UserMembership::whereHas('user')->where('payment_gateway', 'manual_payment')->count();
        $route = route("admin.user.membership.paginate.data");

        return view('membership::backend.user-membership.all-membership', compact(['all_memberships', 'active_membership', 'inactive_membership', 'manual_membership', 'route']));
    }

    // pagination
    function pagination(Request $request)
    {
        if ($request->ajax()) {
            $all_memberships = $request->string_search == ''
                ? UserMembership::whereHas('user')->with('membership:id,membership_type_id')->latest()->paginate(10)
                : UserMembership::whereHas('user')->with('membership:id,membership_type_id')->latest()->$this->query__($request);

            $route = route("admin.user.membership.paginate.data");

            return view('membership::backend.user-membership.search-result', compact('all_memberships', 'route'))->render();
        }
    }

    // search string
    public function search_membership(Request $request)
    {
        $query = UserMembership::whereHas('user')->latest();
        if ($request->filter_val != '') {
            if ($request->filter_val == 1) {
                $query->where('status', 1);
            }
            if ($request->filter_val == 0) {
                $query->where('status', 0);
            }
            if ($request->filter_val == 'manual_payment') {
                $query->where('payment_gateway', 'manual_payment');
            }
        }

        $all_memberships = $query->where(function ($q) use ($request) {
            $q->where('id', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('user_id', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('created_at', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('expire_date', 'LIKE', "%" . strip_tags($request->string_search) . "%");
        })->paginate(10);

        $route = route("admin.user.membership.search");

        return $all_memberships->total() >= 1 ? view('membership::backend.user-membership.search-result', compact('all_memberships', 'route'))->render() : response()->json(['status' => __('nothing')]);
    }

    //change status
    public function change_status($id)
    {
        $membership = UserMembership::find($id);
        $user_firstname = $membership->user?->first_name ?? '';
        $user_email = $membership->user?->email ?? '';
        $status = $membership->status == 1 ? 0 : 1;

        $last_membership_id = $membership->id;
        $membership = UserMembership::find($last_membership_id);
        $membership_type = $membership->membership?->membership_type?->type;
        $membership_price = float_amount_with_currency_symbol($membership->price);
        $membership_expire_date = isset($membership->expire_date) ? Carbon::parse($membership->expire_date)->toFormattedDateString() : '';

        if ($status == 0) {
            // send to user
            try {
                $subject = get_static_option('user_membership_inactive_email_subject') ?? __('membership Inactive');
                $message = get_static_option('user_membership_inactive_message') ?? __('Your membership status changed from active to inactive.');
                $message = str_replace(["@membership_id", "@membership_type", "@membership_price", "@membership_expire_date"], [$last_membership_id, $membership_type, $membership_price, $membership_expire_date], $message);
                Mail::to($user_email)->send(new BasicMail([
                    'subject' => $subject,
                    'message' => $message
                ]));
            } catch (\Exception $e) {
            }
        } else {
            // send to user
            try {
                $subject = get_static_option('user_membership_active_email_subject') ?? __('membership Active');
                $message = get_static_option('user_membership_active_message') ?? __('Your membership status changed from inactive to active.');
                $message = str_replace(["@membership_id", "@membership_type", "@membership_price", "@membership_expire_date"], [$last_membership_id, $membership_type, $membership_price, $membership_expire_date], $message);
                Mail::to($user_email)->send(new BasicMail([
                    'subject' => $subject,
                    'message' => $message
                ]));
            } catch (\Exception $e) {
            }
        }
        UserMembership::where('id', $id)->update(['status' => $status]);
        return back()->with(FlashMsg::item_new(__('Status successfully changed')));
    }

    //active membership
    public function active_membership(Request $request)
    {
        $all_memberships = $request->string_search == ''
            ? UserMembership::whereHas('user')->where('status', 1)->paginate(10)
            : UserMembership::whereHas('user')->latest()->where('status', 1)->$this->query__($request);

        $route = route("admin.user.membership.active");

        return $all_memberships->total() >= 1 ? view('membership::backend.user-membership.search-result', compact('all_memberships', 'route'))->render() : response()->json(['status' => __('nothing')]);
    }

    //inactive membership
    public function inactive_membership(Request $request)
    {
        $all_memberships = $request->string_search == ''
            ? UserMembership::whereHas('user')->where('status', 0)->paginate(10)
            : UserMembership::whereHas('user')->latest()->where('status', 0)->$this->query__($request);
        $route = route("admin.user.membership.active");

        return $all_memberships->total() >= 1 ? view('membership::backend.user-membership.search-result', compact('all_memberships', 'route'))->render() : response()->json(['status' => __('nothing')]);
    }

    //manual membership
    public function manual_membership(Request $request)
    {
        $all_memberships = $request->string_search == ''
            ? UserMembership::whereHas('user')->where('payment_gateway', 'manual_payment')->paginate(10)
            : UserMembership::whereHas('user')->latest()->where('payment_gateway', 'manual_payment')->$this->query__($request);
        $route = route("admin.user.membership.active");

        return $all_memberships->total() >= 1 ? view('membership::backend.user-membership.search-result', compact('all_memberships', 'route'))->render() : response()->json(['status' => __('nothing')]);
    }

    //read unread
    public function read_unread($id)
    {
        AdminNotification::where('identity', $id)->update(['is_read' => 1]);
        return redirect()->route('admin.user.membership.all');
    }

    //update manual payment
    public function update_manual_payment(Request $request)
    {
        $membership_details = UserMembership::find($request->membership_id);

        if (!$membership_details) {
            Log::error('Membership not found', ['membership_id' => $request->membership_id]);
            return back()->with(FlashMsg::item_delete(__('Membership Not Found')));
        }

        $user_id = $membership_details->user_id;

        $history_membership_details = MembershipHistory::where('user_id', $user_id)
            ->where('payment_status', 'pending')
            ->where('payment_gateway', 'manual_payment')
            ->first();

        Log::info('Found membership details', [
            'user_id' => $user_id,
            'membership_id' => $membership_details->membership_id
        ]);

        $updated = UserMembership::where('id', $request->membership_id)->update([
            'payment_status' => 'complete',
            'status' => 1
        ]);

        if ($history_membership_details) {
            $history_updated = $history_membership_details->update([
                'payment_status' => 'complete',
                'status' => 1
            ]);

            Log::info('MembershipHistory update status', ['updated' => $history_updated]);
        } else {
            Log::warning('No pending MembershipHistory found for user', ['user_id' => $user_id]);
        }

        $new_membership = Membership::find($membership_details->membership_id);
        $bv_points = $new_membership ? $new_membership->bv_points : 0;

        $userBvUpdated = UsersBv::updateOrCreate(
            ['user_id' => $user_id],
            ['membership_id' => $membership_details->membership_id, 'bv_points' => $bv_points, 'upgrade_time' => now()]
        );

        Log::info('UserBvs table updated', [
            'user_id' => $user_id,
            'membership_id' => $membership_details->membership_id,
            'bv_points' => $bv_points
        ]);

        return redirect()->back()->with(FlashMsg::item_new(__('Payment Successfully Changed')));
    }


    public function history_update_manual_payment(Request $request)
    {
        Log::info('history_update_manual_payment called', ['membership_history_id' => $request->membership_history_id]);

        $user_membership_history = MembershipHistory::find($request->membership_history_id);
        if (!$user_membership_history) {
            Log::error('Membership History not found', ['membership_history_id' => $request->membership_history_id]);
            return back()->with(FlashMsg::item_delete(__('Membership History Not Found')));
        }

        $user_id = $user_membership_history->user_id;
        $new_membership_id = $user_membership_history->membership_id;

        $user_membership = UserMembership::where('user_id', $user_id)->first();

        if ($user_membership && $user_membership->expire_date > now()) {
            $new_membership = Membership::find($new_membership_id);
            $bv_points = $new_membership ? $new_membership->bv_points : 0;

            UsersBv::updateOrCreate(
                ['user_id' => $user_id],
                ['membership_id' => $new_membership_id, 'bv_points' => $bv_points, 'upgrade_time' => now()]
            );

            Log::info('UserBvs table updated', [
                'user_id' => $user_id,
                'membership_id' => $new_membership_id,
                'bv_points' => $bv_points
            ]);
        }

        return redirect()->back()->with(FlashMsg::item_new(__('Payment Successfully Changed')));
    }

    private function query__($request)
    {
        UserMembership::where(function ($query) use ($request) {
            $query->where('id', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('user_id', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('created_at', 'LIKE', "%" . strip_tags($request->string_search) . "%")
                ->orWhere('expire_date', 'LIKE', "%" . strip_tags($request->string_search) . "%");
        })->paginate(10);
    }

    public function send_email_to_user($id = null)
    {
        $user = UserMembership::find($id);
        $user_email = optional($user->user)->email;
        $expire_date = date('d-m-Y', strtotime($user->expire_date));

        //Send to user
        try {
            $message_body_user = __('Dear user,') . '</br>'
                . '<span class="verify-code">' . __('Your membership will be expired on') . ' ' . $expire_date . '</br>'
                . '</span>';

            Mail::to($user_email)->send(new BasicMail([
                'subject' => __('Membership Reminder'),
                'message' => $message_body_user
            ]));

        } catch (\Exception $e) {
            \Toastr::error($e->getMessage());
        }
        return redirect()->back()->with(FlashMsg::item_new(__('Email Send Success')));
    }
}
