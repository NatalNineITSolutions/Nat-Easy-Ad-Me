<?php

namespace Modules\Membership\app\Http\Controllers\Frontend;

use App\Helpers\PaymentGatewayCredential;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Backend\AdminNotification;
use App\Models\User;
use App\Models\UsersBV;
use App\Services\BVDistributionService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Membership\app\Models\MembershipHistory;
use Modules\Membership\app\Models\UserMembership;
use Modules\Membership\app\Models\Membership;
use Xgenious\Paymentgateway\Facades\XgPaymentGateway;

class BuyMembershipIPNController extends Controller
{
    protected function cancel_page()
    {
        return redirect()->route('membership.buy.payment.cancel.static');
    }

    public function paypal_ipn_for_membership()
    {
        $paypal = PaymentGatewayCredential::get_paypal_credential();
        $payment_data = $paypal->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    public function paytm_ipn_for_membership()
    {
        $paytm = PaymentGatewayCredential::get_paytm_credential();
        $payment_data = $paytm->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function flutterwave_ipn_for_membership()
    {
        $flutterwave = PaymentGatewayCredential::get_flutterwave_credential();
        $payment_data = $flutterwave->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function stripe_ipn_for_membership()
    {
        $stripe = PaymentGatewayCredential::get_stripe_credential();
        $payment_data = $stripe->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function razorpay_ipn_for_membership()
    {
        $razorpay = PaymentGatewayCredential::get_razorpay_credential();
        $payment_data = $razorpay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function paystack_ipn_for_membership()
    {
        $paystack = PaymentGatewayCredential::get_paystack_credential();
        $payment_data = $paystack->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function payfast_ipn_for_membership()
    {
        $payfast = PaymentGatewayCredential::get_payfast_credential();
        $payment_data = $payfast->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function mollie_ipn_for_membership()
    {
        $mollie = PaymentGatewayCredential::get_mollie_credential();
        $payment_data = $mollie->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function midtrans_ipn_for_membership()
    {
        $midtrans = PaymentGatewayCredential::get_midtrans_credential();
        $payment_data = $midtrans->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function cashfree_ipn_for_membership()
    {
        $cashfree = PaymentGatewayCredential::get_cashfree_credential();
        $payment_data = $cashfree->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function instamojo_ipn_for_membership()
    {
        $instamojo = PaymentGatewayCredential::get_instamojo_credential();
        $payment_data = $instamojo->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function marcadopago_ipn_for_membership()
    {
        $marcadopago = PaymentGatewayCredential::get_marcadopago_credential();
        $payment_data = $marcadopago->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function squareup_ipn_for_membership()
    {
        $squareup = PaymentGatewayCredential::get_squareup_credential();
        $payment_data = $squareup->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function cinetpay_ipn_for_membership()
    {
        $cinetpay = PaymentGatewayCredential::get_cinetpay_credential();
        $payment_data = $cinetpay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function paytabs_ipn_for_membership()
    {
        $paytabs = PaymentGatewayCredential::get_paytabs_credential();
        $payment_data = $paytabs->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function billplz_ipn_for_membership()
    {
        $billplz = PaymentGatewayCredential::get_billplz_credential();
        $payment_data = $billplz->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function zitopay_ipn_for_membership()
    {
        $zitopay = PaymentGatewayCredential::get_zitopay_credential();
        $payment_data = $zitopay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }
    public function toyyibpay_ipn_for_membership()
    {
        $toyyibpay = PaymentGatewayCredential::get_toyyibpay_credential();
        $payment_data = $toyyibpay->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    private function common_ipn_data($payment_data)
    {
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete') {
            $order_id = $payment_data['order_id'];
            $user_id = session()->get('user_id');
            $membership_history_id = session()->get('membership_history_id');
            $upgrade_membership_id = session()->get('upgrade_membership_id');
            $this->update_database($order_id, $payment_data['transaction_id'], $membership_history_id, $upgrade_membership_id);
            $this->send_jobs_mail($order_id, $user_id);

            toastr_success(__('Membership purchase success'));
            return redirect()->route('user.membership.all');
        }

        return $this->cancel_page();
    }

    public function paystack_common_ipn_data($data)
    {
        return $this->common_ipn_data($data);
    }

    public function send_jobs_mail($last_membership_id, $user_id)
    {
        if (empty($last_membership_id)) {
            return redirect()->route('homepage');
        }
        $user = User::select(['id', 'first_name', 'last_name', 'email'])->where('id', $user_id)->first();
        $name = $user->first_name . ' ' . $user->last_name;
        $email = $user->email;

        $membership = UserMembership::find($last_membership_id);
        $membership_type = $membership->membership?->membership_type?->type;
        $membership_price = float_amount_with_currency_symbol($membership->price);
        $membership_expire_date = isset($membership->expire_date) ? Carbon::parse($membership->expire_date)->toFormattedDateString() : '';

        try {
            //Send membership email to user
            $subject = get_static_option('user_membership_purchase_email_subject') ?? __('Membership purchase email');
            $message = get_static_option('user_membership_purchase_message') ?? __('Your membership purchase successfully completed.');
            $message = str_replace(["@membership_id", "@membership_type", "@membership_price", "@membership_expire_date"], [$last_membership_id, $membership_type, $membership_price, $membership_expire_date], $message);
            Mail::to($user->email)->send(new BasicMail([
                'subject' => $subject,
                'message' => $message
            ]));

            //Send membership email to admin
            $subject = get_static_option('user_membership_purchase_email_subject') ?? __('Membership purchase email');
            $message = get_static_option('user_membership_purchase_message_for_admin') ?? __('A user just purchase a membership.');
            $message = str_replace(["@membership_id", "@membership_type", "@membership_price", "@membership_expire_date", "@name", "@email"], [$last_membership_id, $membership_type, $membership_price, $membership_expire_date, $name, $email], $message);
            Mail::to(get_static_option('site_global_email'))->send(new BasicMail([
                'subject' => $subject,
                'message' => $message
            ]));
        } catch (\Exception $e) {
            Log::error('Failed to clear session: ' . $e->getMessage());
        }
    }

    private function update_database($last_membership_id, $transaction_id, $membership_history_id, $upgrade_membership_id)
    {
        try {


            $last_membership_id = (int) $last_membership_id;
            $membership_history_id = (int) $membership_history_id;

            $membership_details = UserMembership::with('membership')->find($last_membership_id);
            $membership_history = MembershipHistory::find($membership_history_id);

            if (!$membership_details) {
                throw new \Exception("Membership not found for ID: $last_membership_id");
            }

            $check_user_current_membership = UserMembership::where('id', $last_membership_id)
                ->where('user_id', $membership_details->user_id)
                ->where('payment_status', 'complete')
                ->where('status', 1)
                ->where('expire_date', '>', Carbon::now())
                ->exists();

            UserMembership::where('id', $last_membership_id)
                ->where('user_id', $membership_details->user_id)
                ->update([
                    'payment_status' => 'complete',
                    'status' => 1,
                    'transaction_id' => $transaction_id,
                ]);

            MembershipHistory::where('id', $membership_history_id)
                ->where('user_id', $membership_details->user_id)
                ->update([
                    'payment_status' => 'complete',
                    'status' => 1,
                    'transaction_id' => $transaction_id,
                ]);

            Log::info('data to user:', [
                'last_membership_id' => $last_membership_id,
                'membership_history_id' => $membership_history_id,
                "upgrade_membership_id" => $upgrade_membership_id
            ]);


            if ($membership_history && $check_user_current_membership) {
                $expire_date = Carbon::now()->addDays(
                    Carbon::parse($membership_details->expire_date)->diffInDays(Carbon::now()) +
                        Carbon::parse($membership_history->expire_date)->diffInDays(Carbon::now())
                );

                UserMembership::where('id', $last_membership_id)
                    ->where('user_id', $membership_details->user_id)
                    ->update([
                        'membership_id' => $upgrade_membership_id,
                        'payment_status' => 'complete',
                        'status' => 1,
                        'transaction_id' => $transaction_id,
                        'expire_date' => $expire_date,
                    ]);

                // Fetch the new membership details
                $new_membership = Membership::find($upgrade_membership_id);
                if ($new_membership) {
                    $usersBv = UsersBV::create([
                        'user_id' => $membership_details->user_id,
                        'membership_id' => $upgrade_membership_id,
                        'bv_points' => $new_membership->bv_points ?? 0,
                        'upgrade_time' => Carbon::now(),
                    ]);

                    // Distribute BV points to the parent user
                    $user = User::find($membership_details->user_id);
                    $bvService = new BVDistributionService();
                    $bvService->distributeBVPoints($user, $usersBv->bv_points, $upgrade_membership_id, $membership_details->user_id);
                }
            }

            AdminNotification::create([
                'identity' => $last_membership_id,
                'user_id' => $membership_details->user_id,
                'type' => __('Buy Membership'),
                'message' => __('User membership purchase'),
            ]);

            session()->forget(['order_id', 'user_id', 'membership_history_id', 'upgrade_membership_id']);
        } catch (\Exception $e) {
            Log::error('Failed to update membership: ' . $e->getMessage());
        }
    }

    // private function distributeBVPoints($user, $bvPoints, $upgradeMembershipId, $originalUserId)
    // {
    //     if (!$user) {
    //         return;
    //     }
    //     Log::info('Distributed BV points to user:', [
    //         'user_id' => $user->id,
    //         'bv_points' => $bvPoints,
    //         'left' => $user->left_parent_id,
    //         'right' => $user->right_parent_id,
    //     ]);


    //     // Skip the original user (sameeksha) to avoid duplicate entries
    //     if ($user->id === $originalUserId) {
    //         // Recursively distribute BV points to the left and right parents
    //         if ($user->left_parent_id) {
    //             $leftParentUser = User::find($user->left_parent_id);
    //             $this->distributeBVPoints($leftParentUser, $bvPoints, $upgradeMembershipId, $originalUserId);
    //         }
    //         if ($user->right_parent_id) {
    //             $rightParentUser = User::find($user->right_parent_id);
    //             $this->distributeBVPoints($rightParentUser, $bvPoints, $upgradeMembershipId, $originalUserId);
    //         }
    //         return;
    //     }

    //     // Update the current user's BV points in the Users table
    //     $user->bv_points += $bvPoints;
    //     $user->save();

    //     // Create a new entry in the user_bvs table for the distributed BV points
    //     UsersBV::create([
    //         'user_id' => $user->id,
    //         'membership_id' => $upgradeMembershipId, // The upgraded membership ID
    //         'bv_points' => $bvPoints, // The distributed BV points
    //         'upgrade_time' => Carbon::now(), // Timestamp of distribution
    //     ]);

    //     Log::info('Distributed BV points to user:', [
    //         'user_id' => $user->id,
    //         'bv_points' => $bvPoints,
    //         'left' => $user->left_parent_id,
    //         'right' => $user->right_parent_id,
    //     ]);

    //     // Recursively distribute BV points to the left and right parents
    //     if ($user->left_parent_id) {
    //         $leftParentUser = User::find($user->left_parent_id);
    //         $this->distributeBVPoints($leftParentUser, $bvPoints, $upgradeMembershipId, $originalUserId);
    //     }
    //     if ($user->right_parent_id) {
    //         $rightParentUser = User::find($user->right_parent_id);
    //         $this->distributeBVPoints($rightParentUser, $bvPoints, $upgradeMembershipId, $originalUserId);
    //     }
    // }
}
