@extends('frontend.layout.master')
@section('site_title',__('Membership'))
@section('style')
    <style>
        .search_wrapper {
            display: flex;
            justify-content: flex-end;
        }
        input#string_search {
            padding: 10px;
            border: 1px solid #DFDFDF;
            border-radius: 6px;
        }

    </style>
@endsection
@section('content')
    <div class="profile-setting menberhsip-plan-new setting-page-with-table section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')
                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')
                            <div class="main-body">
                                <x-validation.frontend-error/>
                                <x-frontend.user.responsive-icon/>
                                <div class="your-plan d-flex justify-content-between align-items-center">
                                    <h3 class="your-plan-head">{{ __('Your Plan') }}</h3>
                                    <div class="see-all-plan-btn">
                                        @php
                                             $page_url = \App\Models\Backend\Page::find(get_static_option('membership_plan_page'));
                                        @endphp
                                        <a href="@if($page_url) {{ url('/' . $page_url->slug) }}@endif">{{ __('See All Plans') }} <i class="fa-solid fa-angle-right"></i> </a>

                                    </div>
                                </div>

                                @include('membership::frontend.user.membership.user-dashboard-membership-plans')

                                @if(!empty($user_membership))
                                  <!--Membership section start -->
                                    <div class="memberShipCart mt-3">
                                        <!-- Single -->
                                        <div class="singleMember mb-24 box-shadow1">
                                            <div class="memberDetails">
                                                <div class="d-flex align-items-center gap-3 justify-content-between mb-4">
                                                    <h4 class="memberTittle">{{ __('Verified Membership') }}
                                                        @if(!empty($user_membership))
                                                            @php
                                                                $today = now();
                                                                $expireDate = \Carbon\Carbon::parse($user_membership->expire_date);
                                                            @endphp
                                                            @if($expireDate >= $today && $user_membership->payment_status == 'complete' && $user_membership->status === 1)
                                                                <span class="activeUser"> {{ __('Active') }} </span>
                                                            @elseif($expireDate >= $today && $user_membership->payment_status == 'pending' && $user_membership->status === 0)
                                                                <span class="status pending-status"> {{ __('Inactive') }} </span>
                                                            @elseif($expireDate >= $today && $user_membership->payment_status == 'complete' && $user_membership->status === 0)
                                                                <span class="status pending-status"> {{ __('Inactive') }} </span>
                                                            @elseif($expireDate >= $today && empty($user_membership->payment_status) && $user_membership->status === 0)
                                                                <span class="status pending-status"> {{ __('Inactive') }} </span>
                                                            @else
                                                                <span class="status cancel-status"> {{ __('Expire') }} </span>
                                                            @endif
                                                        @endif
                                                    </h4>

                                                    <!--Current Membership modal button -->
                                                    <div class="btn-wrapper">
                                                        <a href="#" class="red-btn view-details-btn"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#current_membership_modal"
                                                           data-renew_id="{{$user_membership->membership_id}}">
                                                            {{  get_static_option('current_membership_button_title') ?? __('View') }}
                                                        </a>

                                                        <!--renew button -->
                                                        @if(!empty($user_membership))
                                                            @if($user_membership->price != 0)
                                                                @php
                                                                    $today = now();
                                                                    $expireDate = \Carbon\Carbon::parse($user_membership->expire_date);
                                                                    $daysUntilExpiration = $today->diffInDays($expireDate);
                                                                    $renew_expire_days = intval(get_static_option('renew_button_before_expire_days')) ?? 7;
                                                                @endphp

                                                                 <a href="@if($page_url) {{ url('/' . $page_url->slug) }}@endif"  class="red-global-btn"> {{__('Upgrade') }}</a>

                                                                <!-- If not expired, payment status is complete, and within 7 days, show the renewal button -->
                                                                @if($user_membership->payment_status == 'complete' && $expireDate >= $today &&
                                                                    ($daysUntilExpiration <= $renew_expire_days ||
                                                                    $user_membership->listing_limit == 0 ||
                                                                    $user_membership->featured_listing == 0))
                                                                    <a href="#"
                                                                       class="red-btn renew_current_membership"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#renew_membership_modal"
                                                                       data-renew_id="{{$user_membership->membership_id}}"
                                                                    >{{  get_static_option('membership_renew_button_title') ?? __('Renew Current Membership') }}</a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="infoSingle d-flex justify-content-between">
                                                    <ul class="listing">
                                                        <li class="listItem">
                                                            <strong>{{ __('Billing:') }}</strong>
                                                            {{ $user_membership->membership?->membership_type?->type }}
                                                        </li>
                                                        <li class="listItem">
                                                            <span class="text-danger">{{ __('Expire Date:') }}</span>
                                                            {{ \Carbon\Carbon::parse($user_membership->expire_date)->isoFormat('DD, MMM YYYY') }}
                                                        </li>
                                                        @if($user_membership->price != 0)
                                                            <li class="listItem">
                                                                {{ calculateMembershipRemainingTime($user_membership->expire_date) }}
                                                                {{ __('remaining to next invoice') }}
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /END -->

                                    <div class="paymentTable mt-4">
                                        <div class="single-profile-settings" id="display_client_profile_info">
                                            <div class="single-profile-settings-header">
                                                <div class="single-profile-settings-header-flex">
                                                    <h4 class="memberTittle">{{__('Membership History')}}</h4>
                                                    <x-search.search-in-table :id="'string_search'" :placeholder="__('Enter date to search')" :class="'form-control radius-10'" />
                                                </div>
                                            </div>
                                            <div class="single-profile-settings-inner profile-border-top">
                                                <div class="custom_table style-04 search_result">
                                                    @include('membership::frontend.user.membership.search-result')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <!--Membership section end -->
                                @endif
                            </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    @include('membership::addon-view.gateway-markup')
    @include('membership::frontend.user.membership.renew-gateway-markup')
    <!--user current membership info-->
    @include('membership::frontend.user.membership.user-current-membership-modal')
    @include('membership::frontend.user.membership.user-membership-payment-history-modal')
@endsection
@section('scripts')
    @include('membership::frontend.user.membership.membership-js')
    @include('membership::frontend.user.membership.user-membership-payment-history-modal-js')
@endsection
