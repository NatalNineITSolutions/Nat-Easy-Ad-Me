@extends('backend.admin-master')
@section('site-title')
    {{__('Payout Settings')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css />
    <x-media.css />
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Payout Settings')}}</h4>
                    </div>
                </div>
                <x-validation.error />
                <form action="{{route('payout.settings.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form__input__flex">
                        <!-- Payout Method (Default to Amount) -->
                        <div class="form__input__single">
                            <label for="payout_method" class="form__input__single__label"> {{__('Payout Method')}} <span
                                    class="text-danger">*</span> </label>
                            <select name="payout_method" id="payout_method" class="select2_activation radius-5" disabled>
                                <option value="amount" selected>{{__('Amount')}}</option>
                            </select>
                            <input type="hidden" name="payout_method" value="amount">
                        </div>

                        <!-- Payout Value -->
                        <div class="form__input__single" id="payout_value_field">
                            <label for="payout_value" class="form__input__single__label"> {{__('BV Value')}} <span
                                    class="text-danger">*</span> </label>
                            <input type="number" name="payout_value" id="payout_value" class="form-control radius-5"
                                   value="{{ get_static_option('payout_value') }}" placeholder="{{ __('Enter value') }}">
                        </div>

                        <!-- Payment Type -->
                        <div class="form__input__single">
                            <label for="payment_type" class="form__input__single__label"> {{__('Payment Type')}} <span
                                    class="text-danger">*</span> </label>
                            <select name="payment_type" id="payment_type" class="select2_activation radius-5">
                                <option value="">{{ __('Select Payment Type') }}</option>
                                <option value="day" {{ get_static_option('payment_type') === 'day' ? 'selected' : '' }}>
                                    {{ __('Day') }}
                                </option>
                                <option value="week" {{ get_static_option('payment_type') === 'week' ? 'selected' : '' }}>
                                    {{ __('Week') }}
                                </option>
                                <option value="month" {{ get_static_option('payment_type') === 'month' ? 'selected' : '' }}>
                                    {{ __('Month') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update"
                            class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <x-summernote.js />
    <x-media.js />
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $('.select2_activation').select2();
            });
        })(jQuery)
    </script>
@endsection