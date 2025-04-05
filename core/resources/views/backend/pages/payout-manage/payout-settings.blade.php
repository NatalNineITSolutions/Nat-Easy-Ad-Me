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
        <div class="col-12 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Payout Settings')}}</h4>
                    </div>
                </div>
                <x-validation.error />
                <form action="{{route('payout.settings.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- First Row -->
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="payout_method" class="form__input__single__label">{{__('Payout Method')}} <span class="text-danger">*</span></label>
                                <select name="payout_method" id="payout_method" class="form-control select2_activation radius-5" disabled>
                                    <option value="amount" selected>{{__('Amount')}}</option>
                                </select>
                                <input type="hidden" name="payout_method" value="amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="payout_value" class="form__input__single__label">{{__('BV Value')}} <span class="text-danger">*</span></label>
                                <input type="number" name="payout_value" id="payout_value" class="form-control radius-5"
                                       value="{{ get_static_option('payout_value') }}" placeholder="{{ __('Enter value') }}">
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="payment_type" class="form__input__single__label">{{__('Payment Type')}} <span class="text-danger">*</span></label>
                                <select name="payment_type" id="payment_type" class="form-control select2_activation radius-5">
                                    <option value="">{{ __('Select Payment Type') }}</option>
                                    <option value="day" {{ get_static_option('payment_type') === 'day' ? 'selected' : '' }}>{{ __('Day') }}</option>
                                    <option value="week" {{ get_static_option('payment_type') === 'week' ? 'selected' : '' }}>{{ __('Week') }}</option>
                                    <option value="month" {{ get_static_option('payment_type') === 'month' ? 'selected' : '' }}>{{ __('Month') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="referral_value" class="form__input__single__label">{{__('Referral value')}} <span class="text-danger">*</span></label>
                                <input type="number" name="referral_value" id="referral_value" class="form-control radius-5"
                                       value="{{ get_static_option('referral_value') }}" placeholder="{{ __('Enter referral value') }}">
                            </div>
                        </div>

                        <!-- Third Row -->
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="referral_percentage" class="form__input__single__label">{{__('Referral Percentage (%)')}}<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="referral_percentage" id="referral_percentage" class="form-control radius-5"
                                       value="{{ get_static_option('referral_percentage') }}" placeholder="{{ __('Enter referral percentage') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="maximum_referrals" class="form__input__single__label">{{__('Maximum referrals')}}<span class="text-danger">*</span></label>
                                <input type="number" name="maximum_referrals" id="maximum_referrals" class="form-control radius-5"
                                       value="{{ get_static_option('maximum_referrals') }}" placeholder="{{ __('Enter maximum referrals') }}">
                            </div>
                        </div>

                        <!-- Fourth Row -->
                        <div class="col-md-6">
                            <div class="form__input__single mb-3">
                                <label for="bp_value" class="form__input__single__label">{{__('Business Point')}}<span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="bp_value" id="bp_value" class="form-control radius-5"
                                       value="{{ get_static_option('bp_value') }}" placeholder="{{ __('Enter BP Value') }}">
                            </div>
                        </div>
                    </div>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Save Changes') }}</button>
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
                $('.summernote').summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        })(jQuery)
    </script>
@endsection