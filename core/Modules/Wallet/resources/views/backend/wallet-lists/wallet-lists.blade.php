@extends('backend.admin-master')
@section('site-title')
    {{__('Wallet Lists')}}
@endsection
@section('style')
    <x-media.css/>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <div class="dashboard__inner__header__flex">
                        <div class="dashboard__inner__header__left">
                            <h4 class="dashboard__inner__header__title">{{ __('Wallet Lists') }}</h4>
                        </div>
                        <div class="dashboard__inner__header__right">
                            <div class="d-flex text-right w-100 mt-3">
                                <input class="form__control" name="string_search" id="string_search" placeholder="{{ __('Search') }}">
                            </div>
                        </div>
                    </div>
                    <x-validation.error/>
                </div>
                <div class="tableStyle_three mt-4">
                    <div class="table_wrapper custom_Table">
                        <div class="search_result">
                            @include('wallet::backend.wallet-lists.search-result')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('wallet::backend.wallet-lists.wallet-js')
@endsection
