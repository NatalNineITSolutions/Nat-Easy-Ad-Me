<?php

namespace App\Http\Controllers\Frontend\User;

use App\Helpers\FlashMsg;
use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Backend\IdentityVerification;
use App\Models\Frontend\AccountDeactivate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Modules\Membership\app\Models\BusinessHours;
use Modules\Membership\app\Models\UserMembership;

class AccountSettingController extends Controller
{
    public function userAccountSetting(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        $user = User::where('id', $user_id)->first();
        if ($request->isMethod('post')) {
            $request->validate([
                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|min:6',
            ]);
            if (Hash::check($request->current_password, $user->password)) {
                if ($request->new_password == $request->confirm_password) {
                    User::where('id', $user->id)->update([
                        'password' => Hash::make($request->new_password),
                        'password_changed_at' => now(),
                    ]);
                    toastr_success(__('Password Update Success---'));
                    return redirect()->back();
                }
                toastr_error(__('Password and Confirm Password not match---'));
                return redirect()->back();
            }
            toastr_error(__('Current Password is Wrong---'));
            return redirect()->back();
        }
        $user_account_info = AccountDeactivate::where('user_id', $user_id)->first();
        $user_verify_info = IdentityVerification::where('user_id', $user_id)->first();

        $business_hours_data = null;
        if (moduleExists('Membership')) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $user_membership = UserMembership::where('user_id', $user_id)->first();
                if ($user_membership->business_hour === 1) {
                    $user_business_hours = BusinessHours::where('user_id', $user_id)->first();
                    if ($user_business_hours) {
                        $business_hours_data = json_decode($user_business_hours->day_of_week, true);
                    } else {
                        $business_hours_data = null;
                    }
                }
            }
        }

        $user_verify_info = IdentityVerification::where('user_id', $user_id)->first();

        return view('frontend.user.profile.account-settings', compact('user_account_info', 'user_verify_info', 'business_hours_data'));
    }

    // buyer account Deactivate
    public function accountDeactive(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'reason' => 'required',
                'description' => 'required|max:150',
            ]);
            //Deactivate Account
            AccountDeactivate::create([
                'user_id' => Auth::guard('web')->user()->id,
                'reason' => $request['reason'],
                'description' => $request['description'],
                'status' => 0,
                'account_status' => 0,
            ]);
            toastr_error(__('Your Account Successfully Deactivate'));
            return redirect()->back();
        }
    }

    // buyer account delete
    public function accountDelete(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'reason' => 'required',
                'description' => 'required|max:150',
            ]);
            AccountDeactivate::create([
                'user_id' => Auth::guard('web')->user()->id,
                'reason' => $request['reason'],
                'description' => $request['description'],
                'status' => 1,
                'account_status' => 1,
            ]);
            toastr_error(__('Your Account Delete Successfully'));
        }
        return redirect()->route('user.logout');
    }

    // buyer account Deactivate Cancel
    public function accountDeactiveCancel($id = null)
    {
        $account_details = AccountDeactivate::where('user_id', $id)->first();
        if (!empty($account_details)) {
            $account_details->delete();
        }
        toastr_success(__('Your Account Successfully Active'));
        return redirect()->back();
    }

    //user verify
    public function userProfileVerify(Request $request)
    {
        $request->validate([
            'identification_type' => 'required|max:191',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'identification_number' => 'required',
            'pancard_no' => 'required|string|max:20',
            'bank_account_no' => 'required|string|max:30',
            'ifsc_code' => 'required|string|max:20',
        ]);

        // Initialize variables for file names
        $front_imageName = null;
        $back_imageName = null;

        // Handle front document upload
        if ($request->hasFile('front_document')) {
            $request->validate([
                'front_document' => 'file|mimes:jpg,png,jpeg,webp,pdf|max:10240',
            ]);

            $front_document = $request->file('front_document');
            $front_imageName = time() . '-' . uniqid() . '.' . $front_document->getClientOriginalExtension();

            $file_extension = $front_document->getClientOriginalExtension();
            if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $processed_image = Image::make($front_document);
                $processed_image->save('assets/uploads/verification/' . $front_imageName);
            } else {
                $front_document->move('assets/uploads/verification', $front_imageName);
            }
        }

        // Handle back document upload
        if ($request->hasFile('back_document')) {
            $request->validate([
                'back_document' => 'file|mimes:jpg,png,jpeg,webp,pdf|max:10240',
            ]);

            $back_document = $request->file('back_document');
            $back_imageName = time() . '-' . uniqid() . '.' . $back_document->getClientOriginalExtension();

            $file_extension = $back_document->getClientOriginalExtension();
            if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $processed_image = Image::make($back_document);
                $processed_image->save('assets/uploads/verification/' . $back_imageName);
            } else {
                $back_document->move('assets/uploads/verification', $back_imageName);
            }
        }

        // Validate that at least one document is uploaded for new verification
        $old_document = IdentityVerification::where('user_id', auth()->id())->first();
        if (is_null($old_document) && (is_null($front_imageName) || is_null($back_imageName))) {
            return redirect()->back()->withErrors([
                'front_document' => __('Both front and back documents are required for new verification'),
                'back_document' => __('Both front and back documents are required for new verification'),
            ]);
        }

        $user = auth()->id();
        $data = [
            'user_id' => $user,
            'identification_type' => $request->identification_type,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'identification_number' => $request->identification_number,
            'pancard_no' => $request->pancard_no,
            'bank_account_no' => $request->bank_account_no,
            'ifsc_code' => $request->ifsc_code,
            'status' => 0, // Reset status when updating
        ];

        // Only update document fields if new files were uploaded
        if (!is_null($front_imageName)) {
            $data['front_document'] = $front_imageName;
        }
        if (!is_null($back_imageName)) {
            $data['back_document'] = $back_imageName;
        }

        if (is_null($old_document)) {
            // Ensure both documents are present for new verification
            if (is_null($front_imageName) || is_null($back_imageName)) {
                return redirect()->back()->withErrors([
                    'front_document' => __('Both front and back documents are required'),
                    'back_document' => __('Both front and back documents are required'),
                ]);
            }

            IdentityVerification::create($data);
        } else {
            IdentityVerification::where('user_id', $user)->update($data);
        }

        try {
            $subject = get_static_option('user_identity_verification_subject') ?? __('User Verification Request');
            $message = get_static_option('admin_user_identity_verification_message');
            Mail::to(get_static_option('site_global_email'))->send(new BasicMail([
                'subject' => $subject,
                'message' => $message
            ]));
        } catch (\Exception $e) {
            return redirect()->back()->with(FlashMsg::item_new($e->getMessage()));
        }

        toastr_success(__('Verification information updated successfully'));
        return redirect()->back();
    }
}
