<?php

namespace Modules\Membership\app\Http\Controllers\Frontend;

use App\Helpers\PaymentGatewayCredential;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Backend\AdminNotification;
use App\Models\ProfileListing;
use App\Models\User;
use App\Models\UsersBV;
use App\Services\BVDistributionService;
use App\Services\MembershipService;
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


        Log::info('Razorpay IPN Data: ', $payment_data);

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

    // private function common_ipn_data($payment_data)
    // {
    //     if (isset($payment_data['status']) && $payment_data['status'] === 'complete') {
    //         $order_id = $payment_data['order_id'];

    //         // If payment type is 'matrimony', only update the profile listing record and return.
    //         if (session('payment_type') === 'matrimony') {
    //             $payment_method = $payment_data['payment_method'] ?? 'unknown';
    //             $this->update_profile_listing($order_id, $payment_method);
    //             session()->forget('payment_type');

    //             toastr_success(__('Profile On Review'));
    //             return redirect()->route('matrimony.profile-listing');
    //         }

    //         // Otherwise, continue with the regular process.
    //         $user_id = session()->get('user_id');
    //         $membership_history_id = session()->get('membership_history_id');
    //         $upgrade_membership_id = session()->get('upgrade_membership_id');
    //         $this->update_database($order_id, $payment_data['transaction_id'], $membership_history_id, $upgrade_membership_id);
    //         $this->send_jobs_mail($order_id, $user_id);


    //         Log::info('data to update:', [
    //             "upgrade_membership_id" => $upgrade_membership_id
    //         ]);
    //         // Check the membership category to determine redirection.
    //         $membership = Membership::find($upgrade_membership_id);
    //         if ($membership && $membership->category == 1) {
    //             toastr_success(__('Membership purchase success'));
    //             return redirect()->route('matrimony.price');
    //         }

    //         toastr_success(__('Membership purchase success'));
    //         return redirect()->route('user.membership.all');
    //     }

    //     return $this->cancel_page();
    // }


    private function common_ipn_data($payment_data)
    {
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete') {
            $order_id = $payment_data['order_id'];

            // If payment type is 'matrimony', handle separately
            if (session('payment_type') === 'matrimony') {
                $payment_method = $payment_data['payment_method'] ?? 'unknown';
                $this->update_profile_listing($order_id, $payment_method);
                session()->forget('payment_type');

                toastr_success(__('Profile On Review'));
                return redirect()->route('matrimony.profile-listing');
            }

            $user_id = session()->get('user_id');
            $membership_history_id = session()->get('membership_history_id');
            $upgrade_membership_id = session()->get('upgrade_membership_id');

            // Fallback: Get upgrade_membership_id from UserMembership if not set
            if (!$upgrade_membership_id && $order_id) {
                $userMembership = UserMembership::find($order_id);
                if ($userMembership) {
                    $upgrade_membership_id = $userMembership->membership_id;
                    Log::info('Fallback in common_ipn_data: upgrade_membership_id was null, fetched from UserMembership', [
                        'fallback_upgrade_id' => $upgrade_membership_id,
                    ]);
                }
            }

            // Proceed with database update
            $this->update_database($order_id, $payment_data['transaction_id'], $membership_history_id, $upgrade_membership_id);
            $this->send_jobs_mail($order_id, $user_id);

            Log::info('Data to update:', [
                "upgrade_membership_id" => $upgrade_membership_id
            ]);

            // Redirect based on membership category
            $membership = Membership::find($upgrade_membership_id);
            if ($membership && $membership->category == 1) {
                toastr_success(__('Membership purchase success'));
                return redirect()->route('matrimony.price');
            }

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
        if (! $last_membership_id) {
            return redirect()->route('homepage');
        }
    
        $user = User::find($user_id, ['first_name','last_name','email']);
        $name = $user 
            ? trim("{$user->first_name} {$user->last_name}") 
            : 'Guest';
        $email = $user->email ?? null;
    
        $membership = UserMembership::find($last_membership_id);
        if (! $membership) {
            Log::error("Membership #{$last_membership_id} not found");
            return;
        }
    
        // Safely compute price
        $symbols = get_static_option('site_currency_symbol') ?: [];
        $currency = $membership->price_currency ?? 'INR';
        $symbol   = $symbols[$currency] ?? '₹';
        $membership_price = $symbol . number_format($membership->price, 2);
    
        $membership_type        = $membership->membership?->membership_type?->type ?: '—';
        $membership_expire_date = optional($membership->expire_date)
            ? Carbon::parse($membership->expire_date)->toFormattedDateString()
            : '';
    
        // Prepare user email
        $userSubject = get_static_option('user_membership_purchase_email_subject')
                       ?? __('Membership purchase email');
        $userMessage = get_static_option('user_membership_purchase_message')
                       ?? __('Your membership purchase successfully completed.');
        $userMessage = str_replace(
            ["@membership_id","@membership_type","@membership_price","@membership_expire_date"],
            [$last_membership_id,$membership_type,$membership_price,$membership_expire_date],
            $userMessage
        );
    
        // Send user email
        try {
            Mail::to($email)
                ->send(new BasicMail([
                    'subject' => $userSubject,
                    'message' => $userMessage,
                ]));
            Log::info("Membership email sent to user #{$user_id}");
        } catch (\Exception $e) {
            Log::error('Failed to send user membership email: ' . $e->getMessage());
        }
    
        // Prepare admin email
        $adminEmail   = get_static_option('site_global_email');
        $adminSubject = get_static_option('user_membership_purchase_email_subject')
                        ?? __('Membership purchase email');
        $adminMessage = get_static_option('user_membership_purchase_message_for_admin')
                        ?? __('A user just purchased a membership.');
        $adminMessage = str_replace(
            ["@membership_id","@membership_type","@membership_price","@membership_expire_date","@name","@email"],
            [$last_membership_id,$membership_type,$membership_price,$membership_expire_date,$name,$email],
            $adminMessage
        );
    
        // Send admin email
        try {
            Mail::to($adminEmail)
                ->send(new BasicMail([
                    'subject' => $adminSubject,
                    'message' => $adminMessage,
                ]));
            Log::info("Membership notification sent to admin ({$adminEmail})");
        } catch (\Exception $e) {
            Log::error('Failed to send admin membership email: ' . $e->getMessage());
        }
    }
    
    // private function update_profile_listing($order_id, $payment_method)
    // {
    //     // Update the profile listing record
    //     $update = ProfileListing::where('id', $order_id)->update([
    //         'paid' => 1,
    //         'payment_method' => $payment_method,
    //     ]);

    //     // Retrieve the updated profile listing record
    //     $profileListing = ProfileListing::find($order_id);
    //     if (!$profileListing) {
    //         return $update;
    //     }

    //     // Create a BV record for the user
    //     $usersBv = UsersBV::create([
    //         'user_id' => $profileListing->user_id,
    //         'bv_points' => get_static_option('matrimony_bv_points') ?? 0,
    //         'upgrade_time' => \Carbon\Carbon::now(),
    //     ]);

    //     $user = User::find($profileListing->user_id);
    //     $bvService = new BVDistributionService();

    //     $bvService->distributeBVPoints($user, $usersBv->bv_points, null, $profileListing->user_id);

    //     return $update;
    // }


    private function update_profile_listing($order_id, $payment_method)
    {
        // Update the profile listing record
        $update = ProfileListing::where('id', $order_id)->update([
            'paid' => 1,
            'payment_method' => $payment_method,
        ]);

        // Retrieve the updated profile listing record
        $profileListing = ProfileListing::find($order_id);
        if (!$profileListing) {
            return $update;
        }

        // Get BV points from config
        $bvPoints = get_static_option('matrimony_bv_points') ?? 0;

        // Create a BV record for the user
        $usersBv = UsersBV::create([
            'user_id' => $profileListing->user_id,
            'bv_points' => $bvPoints,
            'upgrade_time' => \Carbon\Carbon::now(),
            'type'=> 'Profile Listing',
        ]);

        // Find the user
        $user = User::find($profileListing->user_id);
        if ($user) {
            // Update user's self purchased BV
            $user->self_purchased_bv = ($user->self_purchased_bv ?? 0) + $bvPoints;
            $user->save();

            // Distribute BV
            $bvService = new BVDistributionService();
            $bvService->distributeBVPoints($user, $bvPoints, null, $profileListing->user_id);
        }

        return $update;
    }

    private function update_database($last_membership_id, $transaction_id, $membership_history_id, $upgrade_membership_id)
    {
        try {
            $membershipService = new MembershipService();
            $membershipService->update_database(
                $last_membership_id,
                $transaction_id,
                $membership_history_id,
                $upgrade_membership_id
            );

            session()->forget(['order_id', 'membership_history_id', 'upgrade_membership_id']);
        } catch (\Exception $e) {
            Log::error('Failed to update membership: ' . $e->getMessage());
            throw $e;
        }
    }
}