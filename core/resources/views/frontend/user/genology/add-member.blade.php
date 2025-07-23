@extends('frontend.layout.master')

@section('site_title')
    {{ __('Add New Member') }}
@endsection

@section('style')
    <style>
        .loginArea .login-Wrapper .input-form.input-form2 input {
            padding: 8px 0 6px 56px;
        }

        span#phone_availability {
            font-size: 13px;
        }

        .select2-container .select2-selection--single {
            padding: 15px 16px;
        }
    </style>
@endsection

@section('content')
    <div class="loginArea section-padding2">
        <div class="container">
            <div class="mb-4">
                <button id="toggleShareIcons" class="btn btn-light d-inline-flex align-items-center">
                    <i class="las la-share-alt me-2"></i> {{ __('Share') }}
                </button>

                <div id="shareIcons" class="mt-3 d-none">
                    <a href="#" id="whatsappShare" class="btn btn-success me-2" title="WhatsApp">
                        <i class="lab la-whatsapp"></i>
                    </a>
                    <a href="#" id="facebookShare" class="btn btn-primary me-2" title="Facebook">
                        <i class="lab la-facebook-f"></i>
                    </a>
                    <a href="#" id="instagramShare" class="btn btn-danger me-2" title="Instagram">
                        <i class="lab la-instagram"></i>
                    </a>
                    <button id="copyLink" class="btn btn-secondary" title="Copy Link">
                        <i class="las la-copy"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-5 p-0 order-lg-1 order-1 loginLeft-img">
                    <div class="loginLeft-img">
                        <div class="login-cap">
                            <h3 class="tittle">{{ __('Add New Member') }}</h3>
                            <p class="pera">
                                {{ __('Register a new member under your network.') }}
                            </p>
                        </div>
                        <div class="login-img">
                            {!! render_image_markup_by_attachment_id(get_static_option('register_page_image')) !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 order-lg-1 order-0 login-Wrapper">
                    <x-validation.frontend-error />
                    <form action="{{ route('mlm.registerNewMember') }}" method="POST">
                        @csrf

                        <!-- Hidden fields to carry sponsor and position information -->
                        <input type="hidden" name="position" value="{{ $position }}">

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Sponsor Id') }}</label>
                                <div class="input-group" style="height: 40px;">
                                    <input type="text" class="form-control" 
                                        value="{{ $rootUser?->partner_id ?? $parentUser->partner_id }}"
                                        id="sponsor_id_display" placeholder="{{ __('Sponsor Id') }}"
                                        style="height: 40px; border-radius: 8px;" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Sponsor Name') }}</label>
                                <div class="input-form input-form2" style="padding-top: 5px;">
                                    <input type="text" class="ps-3 form-control" name="sponsor_name" id="sponsor_name"
                                    value="{{ $rootUser?->partner_name ?? $parentUser->partner_name }}"
                                    placeholder="{{ __('Sponsor Name') }}" readonly style="height: 40px;">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Username') }}</label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="username" id="username"
                                        placeholder="{{ __('Type Username') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('First Name') }}</label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="first_name" id="first_name"
                                        placeholder="{{ __('First Name') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Last Name') }}</label>
                                <div class="input-form input-form2">
                                    <input type="text" class="ps-3" name="last_name" id="last_name"
                                        placeholder="{{ __('Last Name') }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Email') }}</label>
                                <div class="input-form input-form2">
                                    <input type="email" name="email" id="email" placeholder="{{ __('Type Email') }}"
                                        required>
                                    <div class="icon">
                                        <i class="lar la-envelope icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Phone Number') }}</label>
                                <div class="input-form input-form2">
                                    <input type="hidden" id="country-code" name="country_code">
                                    <input type="tel" name="phone" id="phone" placeholder="{{ __('Type Phone') }}">
                                    <span id="phone_availability"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Date of Birth') }}</label>
                                <div class="input-form input-form2">
                                    <input type="date" class="ps-3 py-4" name="dob" value="{{old('dob')}}" id="dob"
                                        placeholder="{{ __('Date of Birth') }}" style="height: 40px;">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Gender') }}</label>
                                <div class="input-form input-form2">
                                    <select class="form-select ps-3" name="gender" id="gender" style="height: 40px;">
                                        <option value="">{{ __('Select Gender') }}</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                            {{ __('Female') }}
                                        </option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                            {{ __('Other') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <label class="infoTitle">{{ __('Password') }}</label>
                                <div class="input-form">
                                    <input type="password" name="password" id="password"
                                        placeholder="{{ __('Type Password') }}" required>
                                    <div class="icon"> <i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                        <i class="las la-eye"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 mt-3">
                                <label class="infoTitle">{{ __('Confirm Password') }}</label>
                                <div class="input-form">
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        placeholder="{{ __('Confirm Password') }}" required>
                                    <div class="icon"> <i class="las la-lock icon"></i></div>
                                    <div class="icon toggle-password">
                                        <i class="las la-eye"></i>
                                    </div>
                                </div>
                            </div>

                            <span id="check_password_match" class="mb-2 mt-2"></span>

                            <!-- Terms and Conditions -->
                            <div class="col-lg-12 col-md-12">
                                <label class="checkWrap2 terms-conditions"> {{ __('I agree with the') }}
                                    <a href="{{ url('/' . get_static_option('select_terms_condition_page')) }}"
                                        target="_blank" class="text-primary"> {{ __('Terms and Conditions') }} </a>
                                    <input class="effectBorder check-input" type="checkbox" name="terms_conditions"
                                        id="terms_conditions" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <input type="hidden" name="parent_id" value="{{ $parentUser->id }}">
                            <input type="hidden" name="root_id" value="{{ $rootUser?->id ?? $parentUser->id }}">

                            <div class="col-sm-12 mt-2">
                                <div class="btn-wrapper text-center">
                                    <button type="submit"
                                        class="cmn-btn4 w-100 user-register-form sign_up_now_button">{{ __('Register') }}
                                        <span id="user_register_load_spinner"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleShareIcons');
        const shareIcons = document.getElementById('shareIcons');
        const copyBtn = document.getElementById('copyLink');

        const pageUrl = window.location.href;

        // Toggle icon display
        toggleBtn.addEventListener('click', function () {
            shareIcons.classList.toggle('d-none');
        });

        // Share URLs
        document.getElementById('whatsappShare').href = `https://wa.me/?text=${encodeURIComponent(pageUrl)}`;
        document.getElementById('facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`;
        document.getElementById('instagramShare').href = 'https://www.instagram.com'; // Instagram doesn't support direct sharing

        // Copy to clipboard
        copyBtn.addEventListener('click', function () {
            navigator.clipboard.writeText(pageUrl).then(() => {
                toastr_success_js("{{ __('Link copied to clipboard!') }}");
            }).catch(() => {
                toastr_warning_js("{{ __('Failed to copy link.') }}");
            });
        });
    });
</script>

@section('scripts')
    <x-frontend.js.phone-number-check />
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('keyup', '#confirm_password', function () {
                    let password = $("#password").val();
                    let confirm_password = $("#confirm_password").val();
                    if (password.length >= 6 && confirm_password.length >= 6) {
                        if (password != confirm_password) {
                            $("#check_password_match").html("Password does not match !").css("color", "red");
                        } else {
                            $("#check_password_match").html("Password match !").css("color", "green");
                        }
                    } else {
                        $("#check_password_match").html("");
                    }
                });

                $(document).on('keyup', '#password', function () {
                    let password = $("#password").val();
                    let confirm_password = $("#confirm_password").val();
                    if (password.length >= 6 && confirm_password.length >= 6) {
                        if (confirm_password != '') {
                            if (password != confirm_password) {
                                $("#check_password_match").html("Password does not match !").css("color", "red");
                            } else {
                                $("#check_password_match").html("Password match !").css("color", "green");
                            }
                        } else {
                            $("#check_password_match").html("");
                        }
                    }
                });

                //confirm signup
                $(document).on('click', '.sign_up_now_button', function () {
                    let first_name = $('#first_name').val();
                    let last_name = $('#last_name').val();
                    let username = $('#username').val();
                    let email = $('#email').val();
                    let phone = $('#phone').val();
                    let password = $('#password').val();
                    let confirm_password = $('#confirm_password').val();
                    let password_validation_text = $('#check_password_match').text();

                    if (first_name == '' || last_name == '' || username == '' || email == '' || phone == '' || password == '' || confirm_password == '') {
                        toastr_warning_js("{{ __('Please fill all fields') }}");
                        return false;
                    } else if (password.length < 6) {
                        toastr_warning_js("{{ __('Password must be 6 characters at least') }}");
                        return false;
                    } else if (confirm_password.length < 6) {
                        toastr_warning_js("{{ __('Password must be 6 characters at least') }}");
                        return false;
                    } else if (password_validation_text == 'Password does not match !') {
                        toastr_warning_js("{{ __('Password does not match') }}");
                        return false;
                    }

                    // terms and condition check
                    if (!$('.terms-conditions .check-input').is(":checked")) {
                        toastr_warning_js("{{ __('Please agree with terms and conditions') }}");
                        return false;
                    }

                    $(this).attr("disabled", "disabled");
                    $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{__("Registering")}}');
                    // Submit the form
                    $(this).closest('form').trigger('submit');
                });
            });
        }(jQuery));
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dobInput = document.getElementById("dob");

            dobInput.addEventListener("click", function () {
                this.showPicker();
            });
        });
    </script>
@endsection