<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Mail\BasicMail;
use App\Models\Backend\IdentityVerification;
use App\Models\Frontend\AccountDeactivate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    //view profile
    public function profile()
    {
        return view('frontend.user.profile.profile-settings');
    }

    //edit profile info
    public function edit_profile(Request $request)
    {
        if (!empty($request->profile_bg_image_request) && $request->profile_bg_image_request == 1){
            $request->validate(
                ['profile_background'=>'required'],
                ['profile_background.required'=> __('background image is required')]);
        }else{
            $request->validate(
                [
                    'first_name'=>'required|min:2|max:50',
                    'last_name'=>'required|min:2|max:50',
                    'email'=>'required|email|unique:users,email,'.Auth::guard('web')->user()->id,
                    'phone'=>'required',
                    'country'=>'required',
                    'state'=>'required',
                ],
                [
                    'first_name.required'=> __('First name is required'),
                    'last_name.required'=> __('Last name is required'),
                    'country_id.required'=> __('Country is required'),
                    'state_id.required'=> __('State is required'),
                    'phone.required'=> __('Phone is required'),
                ]);
          }

        if($request->ajax()){
            if (!empty($request->profile_bg_image_request) && $request->profile_bg_image_request == 1){
                User::where('id',Auth::guard('web')->user()->id)->update([
                    'profile_background'=>$request->profile_background,
                ]);
            }else{
                User::where('id',Auth::guard('web')->user()->id)->update([
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'country_id'=>$request->country,
                    'state_id'=>$request->state,
                    'city_id'=>$request->city,
                    'image'=>$request->image,
                ]);
            }

            return response()->json([
                'status'=>'ok',
            ]);
        }
    }


    // member identity verification
    public function identity_verification(Request $request)
    {
        $user_id = Auth::guard('web')->user()->id;
        if($request->isMethod('post')){
            $request->validate([
                'country'=>'required',
                'state'=>'required',
                'city'=>'required',
                'address'=>'required|max:191',
                'zipcode'=>'required|max:191',
                'national_id_number'=>'required|max:191',
                'front_image'=>'required|image|mimes:jpeg,png,jpg|max:1024|dimensions:width=500,height=300',
                'back_image'=>'required|image|mimes:jpeg,png,jpg|max:1024|dimensions:width=500,height=300',
            ]);

            $verification_image = IdentityVerification::where('user_id',$user_id)->first();
            $delete_front_img = '';
            $delete_back_img = '';

            if(!empty($verification_image)){
                $delete_front_img =  'assets/uploads/verification/'.$verification_image->front_image;
                $delete_back_img =  'assets/uploads/verification/'.$verification_image->back_image;
            }

            if ($image = $request->file('front_image')) {
                if(file_exists($delete_front_img)){
                    File::delete($delete_front_img);
                }
                $front_image_name = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();

                // Image scan start
                $uploaded_file = $request->front_image;
                $file_extension = $uploaded_file->getClientOriginalExtension();
                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $processed_image = Image::make($uploaded_file);
                    $image_default_width = $processed_image->width();
                    $image_default_height = $processed_image->height();
                    $processed_image->resize($image_default_width, $image_default_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processed_image->save('assets/uploads/verification/' . $front_image_name);
                }else{
                    $image->move('assets/uploads/verification', $front_image_name);
                } // Image scan end

            }else{
                $front_image_name = $verification_image->front_image;
            }

            if ($image = $request->file('back_image')) {
                if(file_exists($delete_back_img)){
                    File::delete($delete_back_img);
                }
                $back_image_name= time().'-'.uniqid().'.'.$image->getClientOriginalExtension();

                // Image scan start
                $uploaded_file = $request->back_image;
                $file_extension = $uploaded_file->getClientOriginalExtension();
                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $processed_image = Image::make($uploaded_file);
                    $image_default_width = $processed_image->width();
                    $image_default_height = $processed_image->height();
                    $processed_image->resize($image_default_width, $image_default_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processed_image->save('assets/uploads/verification/' . $back_image_name);
                }else{
                    $image->move('assets/uploads/verification', $back_image_name);
                } // Image scan end

            }else{
                $back_image_name = $verification_image->back_image;
            }

            IdentityVerification::updateOrCreate(
                ['user_id'=> $user_id],
                [
                    'user_id'=>$user_id,
                    'verify_by'=>$request->verify_by,
                    'country_id'=>$request->country,
                    'state_id'=>$request->state,
                    'city_id'=>$request->city,
                    'address'=>$request->address,
                    'zipcode'=>$request->zipcode,
                    'national_id_number'=>$request->national_id_number,
                    'front_image'=>$front_image_name,
                    'back_image'=>$back_image_name,
                    'status'=>null,
                ]
            );
            try {
                $message = get_static_option('user_identity_verify_message') ?? "<p>{{ __('Hello')}},</p></p>{{ __('You have a new request for user identity verification')}}</p>";
                Mail::to(get_static_option('site_global_email'))->send(new BasicMail([
                    'subject' => get_static_option('user_identity_verify_subject') ?? __('User Identity Verify Email'),
                    'message' => $message
                ]));
            }
            catch (\Exception $e) {}
            return response()->json(['status'=>'success']);
        }
    }

    // check password
    public function check_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $current_password = User::select('password')->where('id',Auth::user()->id)->first();
            if (Hash::check($request->current_password, $current_password->password)) {
                return response()->json([
                    'status'=>'match',
                    'msg'=>__('Current password match'),
                ]);
            }else{
                return response()->json([
                    'msg'=>__('Current password is wrong'),
                ]);
            }
        }
    }

    // password change
    public function change_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6',
                'confirm_new_password' => 'required|min:6',
            ]);
            $user = User::select(['id','password'])->where('id',Auth::user()->id)->first();

            if (Hash::check($request->current_password, $user->password)) {
                if ($request->new_password == $request->confirm_new_password) {
                    User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);
                    return response()->json(['status'=>'success']);
                }
                return response()->json(['status'=>'not_match']);
            }
            return response()->json(['status'=>'current_pass_wrong']);
        }
        return view('frontend.user.client.password.password');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

}
