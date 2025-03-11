<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendRegisterUserEmailJob;
use App\Mail\BasicMail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Membership\app\Http\Services\MembershipService;
use Modules\Wallet\app\Models\Wallet;
use App\Models\Backend\Admin;

class RegisterController extends Controller
{
    protected $membershipService;

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo(){
        return route('homepage');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (moduleExists("Membership")) {
            if (membershipModuleExistsAndEnable('Membership')) {
                $this->membershipService = app()->make(MembershipService::class);
            }
        }

        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'captcha_token' => ['nullable'],
            'username' => ['required', 'string', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[
            'captcha_token.required' => __('google captcha is required'),
            'name.required' => __('name is required'),
            'name.max' => __('name is must be between 191 character'),
            'username.required' => __('username is required'),
            'username.max' => __('username is must be between 191 character'),
            'username.unique' => __('username is already taken'),
            'email.unique' => __('email is already taken'),
            'email.required' => __('email is required'),
            'password.required' => __('password is required'),
            'password.confirmed' => __('both password does not matched'),
        ]);
    }

    protected function adminValidator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:admins'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'area_id' => $data['area_id']
        ]);
        return $user;
    }

    public function userNameAvailability(Request $request)
    {
        $username = User::where('username',$request->username)->first();
        if(!empty($username) && $username->username == $request->username){
            $status = 'not_available';
            $msg = __('Sorry! Username name is not available');
        }else{
            $status = 'available';
            $msg = __('Congrats! Username name is available');
        }
        return response()->json([
            'status'=>$status,
            'msg'=>$msg,
        ]);
    }

    public function emailAvailability(Request $request)
    {
        $email = User::where('email',$request->email)->first();
        if(!empty($email) && $email->email == $request->email){
            $status = 'not_available';
            $msg = __('Sorry! Email has already taken');
        }else{
            $status = 'available';
            $msg = __('Congrats! Email is available');
        }
        return response()->json([
            'status'=>$status,
            'msg'=>$msg,
        ]);
    }

    public function phoneNumberAvailability(Request $request)
    {
        $phone = User::where('phone',$request->phone)->first();
        if(!empty($phone) && $phone->phone == $request->phone){
            $status = 'not_available';
            $msg = __('Sorry! Phone Number has already taken');
        }else{
            $status = 'available';
            $msg = __('Congrats! Phone number is available');
        }
        return response()->json([
            'status'=>$status,
            'msg'=>$msg,
            'phone'=>$phone,
        ]);
    }

    public function userRegister(Request $request) {
        if ($request->isMethod('POST')) {
            $validationRules = [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'email' => 'required|email|unique:users|max:191',
                'username' => 'required|unique:users|max:191',
                'phone' => 'required|max:191',
                'country_code' => 'required|max:10',
                'password' => 'required|min:6|max:191',
                'confirm_password' => 'required|same:password',
            ];
    
            if (get_static_option('site_google_captcha_enable') == 'on') {
                $validationRules['g-recaptcha-response'] = 'nullable';
            }
    
            $request->validate($validationRules);
    
            $email_verify_token = sprintf("%d", random_int(123456, 999999));
    
            $phone_number = Str::replace(['-', '(', ')', ' '], '', $request->phone);
            $country_code = '+' . ltrim($request->country_code, '+');
            $full_phone_number = $country_code . ' - ' . $phone_number;
    
            if (!empty($full_phone_number) && User::where('phone', $full_phone_number)->exists()) {
                return redirect()->back()->withErrors(['phone' => __('Phone number is already taken')]);
            }
    

            do {
                $partnerId = 'EAM' . Str::upper(Str::random(6)); 
            } while (User::where('partner_id', $partnerId)->exists());
            
            $partnerName = ucwords(strtolower($request->first_name)) . ' ' . ucwords(strtolower($request->last_name));
    
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $full_phone_number, 
                'password' => Hash::make($request->password),
                'terms_conditions' => 1,
                'email_verify_token' => $email_verify_token,
                'partner_id' => $partnerId, // Store the unique partner ID
                'partner_name' => $partnerName, 
            ]);
    
            if (moduleExists("Wallet")) {
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'remaining_balance' => 0,
                    'withdraw_amount' => 0,
                    'status' => 1
                ]);
            }
    
            if ($user && moduleExists("Membership") && membershipModuleExistsAndEnable('Membership')) {
                $this->membershipService->createFreeMembership($user);
            }
    
            if ($user && !empty(get_static_option('user_email_verify_enable_disable'))) {
                try {
                    Mail::to($user->email)->send(new BasicMail([
                        'subject' => __('Otp Email'),
                        'message' => __('Your otp code') . ' ' . $email_verify_token
                    ]));
                } catch (\Exception $e) {}
            }
    
            if ($user) {
                dispatch(new SendRegisterUserEmailJob($user, $request->password));
            }
    
            if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect()->route('user.dashboard');
            }
        }
    
        return view('frontend.user.user-register');
    }       

    public function emailVerify(Request $request)
    {
        $user_details = Auth::guard('web')->user();
        if($request->isMethod('post')){
            $this->validate($request,[
                'email_verify_token' => 'required|max:191'
            ],[
                'email_verify_token.required' => __('verify code is required')
            ]);

            $user_details = User::where(['email_verify_token' => $request->email_verify_token,'email' => $user_details->email ])->first();
            if(!is_null($user_details)){
                $user_details->email_verified = 1;
                $user_details->save();
                return redirect()->route('user.dashboard');
            }
            toastr_warning(__('Your verification code is wrong.'));
            return back();
        }
        $verify_token = $user_details->email_verify_token ?? null;
        try {
            //check user has verify token has or not
            if(is_null($verify_token)){
                $verify_token = Str::random(8);
                $user_details->email_verify_token = Str::random(8);
                $user_details->save();

                $message_body = __('Hello').' '.$user_details->name.' <br>'.__('Here is your verification code').' <span class="verify-code">'.$verify_token.'</span>';
                Mail::to($user_details->email)->send(new BasicMail([
                    'subject' => sprintf(__('Verify your email address %s'),get_static_option('site_title')),
                    'message' => $message_body
                ]));
            }
        }catch (\Exception $e){
        }
        return view('frontend.user.email-verify');
    }

    public function resendCode(){

        $user_details = Auth::guard('web')->user();
        $verify_token = $user_details->email_verify_token ?? null;

        try {
            if(is_null($verify_token)){
                $verify_token = Str::random(8);
                $user_details->email_verify_token = Str::random(8);
                $user_details->save();
            }
            $message_body = __('Hello').' '.$user_details->name.' <br>'.__('Here is your verification code').' <span class="verify-code">'.$verify_token.'</span>';
            Mail::to($user_details->email)->send(new BasicMail([
                'subject' => sprintf(__('Verify your email address %s'),get_static_option('site_title')),
                'message' => $message_body
            ]));
        }catch (\Exception $e){
        }
        return redirect()->back()->with(['msg' => __('Resend Email Verify Code, Please check your inbox of spam.') ,'type' => 'success' ]);
    }

    public function partnerAvailability()
    {
        $admin = Admin::first(); 
        
        if ($admin) {
            return response()->json([
                'success' => true,
                'partner_id' => $admin->partner_id,
                'partner_name' => $admin->partner_name
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'No admin found']);
        }
    }

    public function partneridAvailability(Request $request) {
        $partner = User::where('partner_id', $request->partner_id)->first();
    
        if ($partner) {
            return response()->json(['status' => 'success', 'partner_name' => $partner->partner_name]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Partner ID not found']);
        }
    }
}
