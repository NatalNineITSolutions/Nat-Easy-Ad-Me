@extends('backend.admin-master')
@section('site-title')
    {{__('Deposit Amount Settings')}}
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <div class="dashboard__inner__header__flex">
                        <div class="dashboard__inner__header__left">
                            <h4 class="dashboard__inner__header__title">{{ __('Deposit Amount Settings') }}</h4>
                        </div>
                        <x-notice.general-notice :description="__('Notice: Deposit amount settings refer to the maximum amount a user can deposit into their wallet at one time. For instance, setting it to 500 means a user can deposit up to a maximum of 500 in each transaction.')" />
                    </div>
                </div>
                <x-validation.error />
                <div class="customMarkup__single__inner mt-4">
                    <form action="{{route('admin.wallet.deposit.settings')}}" method="POST">
                        @csrf
                        <x-form.text
                            :title="__('Deposit Limit')"
                            :type="__('text')"
                            :name="'deposit_amount_limitation_for_user'"
                            :id="'deposit_amount_limitation_for_user'"
                            :value="get_static_option('deposit_amount_limitation_for_user') ?? ''"
                        />
                        @can('deposit-settings')
                            <x-btn.submit-btn :title="__('Update')" :class="'cmnBtn btn_5 btn_bg_blue radius-5 update_info'" />
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
