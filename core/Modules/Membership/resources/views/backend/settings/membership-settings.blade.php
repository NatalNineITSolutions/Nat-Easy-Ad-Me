@extends('backend.admin-master')
@section('site-title')
    {{__('Register Membership Settings')}}
@endsection
@section('style')
    <x-media.css/>
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <h4 class="dashboard__inner__header__title">{{ __('Membership Settings') }}</h4>
                </div>
                <x-validation.error/>
                <div class="customMarkup__single__inner mt-4">
                    <form action="{{route('admin.membership.settings')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="single-input my-2">
                            <div class="dashboard__inner__header">
                                <h5 class="dashboard__inner__header__title">{{ __('Register Membership Settings') }}</h5>
                                <x-notice.general-notice :class="'mt-1'" :description="__('Notice: When a new user register by default he/she will get the free membership. Once it is complete or expired he will must buy membership for linting add.')" />
                            </div>
                            <label class="label-title">{{ __('Make Free membership') }}</label>
                            <select name="register_membership" class="form-control">
                                <option value="">{{ __('Select membership') }}</option>
                                @foreach($memberships as $sub)
                                <option value="{{ $sub->id }}" {{ get_static_option('register_membership') == $sub->id ? 'selected' : '' }}>{{ $sub?->membership_type?->type ?? '' }} - {{ $sub->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $fileds = [1 =>'One Day', 2 => 'Two Day', 3 => 'Three Day', 4 => 'Four Day', 5 => 'Five Day', 6 => 'Six Day', 7=> 'Seven Day'];
                        @endphp

                        <div class="form__input__single">
                            <label for="title" class="form__input__single__label">{{__('Select how many days earlier expiration mail alert will be send')}}</label>
                            <div class="category-section">
                                <select name="package_expire_notify_mail_days[]" id="tag_id" class="form__control select2_activation" multiple data-placeholder="{{ __('Select Days') }}">
                                    <option value="" disabled>{{ __('Select Tag') }}</option>
                                    @foreach($fileds as $key => $field)
                                        @php
                                            $package_expire_notify_mail_days = get_static_option('package_expire_notify_mail_days');
                                            $decoded = json_decode($package_expire_notify_mail_days) ?? [];
                                        @endphp
                                        <option value="{{$key}}"
                                        @foreach($decoded as  $day)
                                            {{$day == $key ? 'selected' : ''}}
                                            @endforeach
                                        >{{__($field)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Membership Buy button Title') }}</label>
                            <input class="form-control" name="membership_get_started_button_title"  value="{{get_static_option('membership_get_started_button_title')}}"/>
                        </div>

                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Membership Upgrade button Title') }}</label>
                            <input class="form-control" name="membership_upgrade_button_title"  value="{{get_static_option('membership_upgrade_button_title')}}"/>
                        </div>

                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Membership Renew button Title') }}</label>
                            <input class="form-control" name="membership_renew_button_title"  value="{{get_static_option('membership_renew_button_title')}}"/>
                        </div>

                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Membership Renew Modal Title') }}</label>
                            <input class="form-control" name="membership_renew_modal_title"  value="{{get_static_option('membership_renew_modal_title')}}"/>
                        </div>

                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Current Membership Button Title') }}</label>
                            <input class="form-control" name="current_membership_button_title"  value="{{get_static_option('current_membership_button_title')}}"/>
                        </div>

                        <div class="single-input my-2">
                            <label class="label-title">{{ __('Current Membership Modal Title') }}</label>
                            <input class="form-control" name="current_membership_modal_title"  value="{{get_static_option('current_membership_modal_title')}}"/>
                        </div>

                        <div class="form-group mt-2">
                            <label for="renew_button_before_expire_days">{{ __('Select the day to display the renew button before they expire.') }}</label>
                            <select name="renew_button_before_expire_days" class="form-control">
                                <option value="" disabled>{{ __('Select day') }}</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}" @if(get_static_option('renew_button_before_expire_days') == $i) selected @endif>
                                        {{ $i }} {{ __('day') . ($i > 1 ? 's' : '') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="btn_wrapper mt-4">
                            <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
         </div>
    </div>
    <x-media.markup/>
@endsection
@section('scripts')
    <x-media.js/>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
@endsection
