@extends('frontend.layout.master')
@section('site_title',__('Wallet History'))
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
    <div class="profile-setting setting-page-with-table wallet-page section-padding2">
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
                                <div class="memberShipCart">
                                    <div class="singleMember mb-24">
                                        <div class="memberDetails">
                                            <p>{{ __('Available Balance:') }}</p>
                                            <h4 class="balance-wallet">{{ float_amount_with_currency_symbol($total_wallet_balance ?? 00) }}</h4>
                                        </div>
                                        <div class="btn-wrapper mb-20">
                                            <button class="red-btn" data-bs-toggle="modal" data-bs-target="#paymentGatewayModal">{{ __('Deposit to Wallet') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="paymentTable">
                                    <div class="single-profile-settings" id="display_client_profile_info">
                                        <div class="single-profile-settings-header">
                                            <x-notice.general-notice :description="__('Notice: Using Deposit balance you can buy membership plan')" />
                                            <div class="single-profile-settings-header-flex">
                                                <h4 class="memberTittle">{{__('Wallet History')}}</h4>
                                                <x-search.search-in-table :id="'string_search'" :placeholder="__('Enter date to search')" :class="'form-control radius-10'" />
                                            </div>
                                        </div>
                                        <div class="single-profile-settings-inner profile-border-top">
                                            <div class="custom_table style-04 search_result">
                                                @include('wallet::user.wallet.search-result')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <x-frontend.payment-gateway.gateway-markup :title="__('Deposit to Wallet')"/>
@endsection
@section('scripts')
    @include('wallet::user.wallet.wallet-js')
@endsection
