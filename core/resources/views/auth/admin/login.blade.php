@extends('layouts.login-screens')

@section('content')
    <section class="loginForm">
        <div class="loginForm__flex">
            <div class="loginForm__left">
                <div class="loginForm__left__inner desktop-center">
                    <div class="loginForm__right__logo">
                        <div class="loginForm__logo">
                            <a href="{{ route('homepage') }}" class="logo">
                                {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                            </a>
                        </div>
                    </div>
                    <div class="loginForm__header">
                        <h2 class="loginForm__header__title text-start">{{ get_static_option('admin_login_page_title') ?? __('Welcome Back') }}</h2>
                        <p class="loginForm__header__para mt-3 text-start">{{  get_static_option('admin_login_page_subtitle') ?? __('Login with your data that you entered during registration.') }} </p>
                    </div>
                    <div class="error-message text-start mt-2">
                        <x-msg.response-message/>
                    </div>
                    <div class="loginForm__wrapper mt-4">
                        <form action="{{ route('admin.login') }}" class="custom_form" method="POST">
                            @csrf
                            <div class="single_input">
                                <label class="label_title">{{ __('Username or Email') }}</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="text" id="username" name="username" placeholder="{{ __('Username or Email') }}">
                                    <div class="icon"><span class="material-symbols-outlined">{{ __('person') }}</span></div>
                                </div>
                            </div>

                            <div class="single_input">
                                <label class="label_title">{{ __('Password') }}</label>
                                <div class="include_icon">
                                    <input class="form--control radius-5" type="password" id="password" placeholder="{{ __('password') }}">
                                    <div class="icon"><span class="material-symbols-outlined">{{ __('lock') }}</span></div>
                                </div>
                            </div>

                            <div class="loginForm__wrapper__remember single_input">
                                <div class="dashboard_checkBox">
                                    <input class="dashboard_checkBox__input" id="remember" type="checkbox">
                                    <label class="dashboard_checkBox__label" for="remember">{{ __('Remember Me') }}</label>
                                </div>
                                <!-- forgetPassword -->
                                <div class="forgotPassword">
                                    <a href="{{ route('admin.forget.password') }}" class="forgotPass">{{ __('Forgot passwords?') }}</a>
                                </div>
                            </div>
                            <div class="btn_wrapper single_input">
                                <button type="submit" id="form_submit" class="cmnBtn btn_5 btn_bg_blue radius-5 radius-5">{{ __('Login') }}</button>
                            </div>
                              @if(preg_match('/(bytesed)/',url('/')))
                                <div class="adminlogin-info">
                                    <table class="table">
                                        <th>{{__('Username')}}</th>
                                        <th>{{__('Password')}}</th>
                                        <th>{{__('Action')}}</th>
                                        <tbody>
                                        <tr class="border-0">
                                            <td class="border-0" id="td_username">super_admin</td>
                                            <td class="border-0" id="td_password">12345678</td>
                                            <td class="border-0">
                                                <button type="button" class="cmnBtn btn_5 btn_bg_success btnIcon radius-5 autoLogin" id="autoLogin">{{__('Login')}}</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                              @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="loginForm__right loginForm__bg" style="background-image: url('{{ get_image_url_id_wise(get_static_option('admin_login_page_background_image')) }}');"></div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        (function($){
           "use strict";
            $(document).ready(function ($){

                $(document).on('click','#autoLogin',function(){
                    let el = $(this);
                    let username = $('#td_username').text();
                    let passwrod = $('#td_password').text();
                    $('#username').val(username);
                    $('#password').val(passwrod);
                    $('#form_submit').trigger('click');
                });

                // admin login
                $(document).on('click','#form_submit',function (e){
                    e.preventDefault();
                    var el = $(this);
                    var erContainer = $(".error-message");
                    erContainer.html('');
                    el.text('{{__('Please Wait..')}}');
                    $.ajax({
                        url: "{{route('admin.login')}}",
                        type: "post",
                        data: {
                            _token : "{{csrf_token()}}",
                            username : $('#username').val(),
                            password : $('#password').val(),
                            remember : $('#remember').val(),
                        },
                        error:function(data){
                            var errors = data.responseJSON;
                            erContainer.html('<div class="alert alert-danger"></div>');
                            $.each(errors.errors, function(index,value){
                                erContainer.find('.alert.alert-danger').append('<p>'+value+'</p>');
                            });
                            el.text('{{__('Login')}}');
                        },
                        success:function (data){
                            $('.alert.alert-danger').remove();
                            if (data.status == 'ok'){
                                el.text('{{__('Redirecting')}}..');
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                location.reload();
                            }else{
                                erContainer.html('<div class="alert alert-'+data.type+'">'+data.msg+'</div>');
                                el.text('{{__('Login')}}');
                            }
                        }
                    });
                });

           });
        })(jQuery);
    </script>
@endsection
