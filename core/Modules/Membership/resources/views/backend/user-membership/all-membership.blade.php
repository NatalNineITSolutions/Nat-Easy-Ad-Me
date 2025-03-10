@extends('backend.admin-master')
@section('site-title')
    {{ __('User Memberships') }}
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <div class="dashboard__inner__header__flex">
                        <div class="dashboard__inner__header__left">
                            <h4 class="dashboard__inner__header__title">{{ __('User membership') }}</h4>
                        </div>
                        <div class="dashboard__inner__header__right">
                            <div class="d-flex text-right w-100 mt-3">
                                <input class="form__control" name="string_search" id="string_search" placeholder="{{ __('Search') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <x-notice.general-notice :description="__(
                    'Notice: A manual payment membership can be used only when the payment status is complete and the status remains active.',
                )" :description1="__('Notice: You can search here by id, user id, purchase date and expire date.')" />
                </div>

                <!--Membership filter section start -->
                <div class="dashboard_order__tab d-flex flex-wrap gap-3 mb-3">
                    <input type="hidden" id="get_selected_value">
                    <ul class="tabs">
                        <li  id="active_membership" class="active" data-val="active-sub">{{ __('Active') }} {{ $active_membership ?? 0 }}</li>
                        <li id="inactive_membership" class="active" data-val="inactive-sub">{{ __('Inactive') }} {{ $inactive_membership ?? 0 }}</li>
                        <li id="manual_membership" class="active" data-val="manual-sub">{{ __('Manual') }} {{ $manual_membership ?? 0 }}</li>
                    </ul>
                </div>
                <!--Membership filter section end -->
                <div class="custom_table style-04 search_result">
                    @include('membership::backend.user-membership.search-result')
                </div>
            </div>
        </div>
    </div>
    @include('membership::backend.user-membership.manual-payment-modal')
    <x-media.markup />
@endsection
@section('scripts')
    @include('membership::backend.user-membership.membership-js')
@endsection
