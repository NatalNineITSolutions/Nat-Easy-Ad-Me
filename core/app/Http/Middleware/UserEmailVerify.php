<?php

namespace App\Http\Middleware;

use Closure;
use Request;

class UserEmailVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {
    //     if(!empty(get_static_option('user_email_verify_enable_disable'))){
    //         if (auth('web')->check() && auth('web')->user()->email_verified == 0 && !empty(get_static_option('user_email_verify_enable_disable')) && request()->path() !== 'user/logout'){
    //             return redirect()->route('email.verify');
    //         }
    //     }elseif((moduleExists('SMSGateway') && isPluginActive('SMSGateway')) && get_static_option('otp_login_status')){
    //         if(!empty(get_static_option('otp_login_status'))){
    //             if (auth('web')->check() && auth('web')->user()->otp_verified == 0 && !empty(get_static_option('otp_login_status')) && request()->path() !== 'user/logout'){
    //                 session()->put('auth_user_id', auth('web')->user()->id);
    //                 return redirect()->route('user.login.otp.verification');
    //             }
    //         }
    //     }

    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        if (!empty(get_static_option('user_email_verify_enable_disable'))) {

            if (auth('web')->check()) {
                $user = auth('web')->user();

                $currentRouteName = $request->route() ? $request->route()->getName() : null;

                $excludedRouteNames = [
                    'email.verify',              
                    'email.verify.submit',  
                    'user.logout',             
                    'frontend.user.email.verify', 
                    'frontend.user.logout',      
                ];

                $excludedPaths = [
                    'user/logout',
                    'email/verify',
                    'user/email-verify',
                ];

                $isExcludedByName = $currentRouteName && in_array($currentRouteName, $excludedRouteNames);
                $isExcludedByPath = $request->is($excludedPaths) || $request->is('email/verify*');

                if ($user->email_verified == 0 && !$isExcludedByName && !$isExcludedByPath) {
                    return redirect()->route('email.verify');
                }
            }
        }

        return $next($request);
    }
}
