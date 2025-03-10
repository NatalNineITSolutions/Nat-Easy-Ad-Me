@extends('backend.admin-master')
@section('site-title')
    {{__('Wallet History')}}
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
                            <h4 class="dashboard__inner__header__title">{{ __('Wallet History') }}</h4>
                            <span class="text-info mt-2">{{ __('All users wallet history') }}</span>

                        </div>
                        <div class="dashboard__inner__header__right">
                            <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5"
                                    data-bs-toggle="modal"
                                    data-bs-target="#payoutRequestModal">
                                {{ __('Deposit To User Wallet') }}
                            </button>
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
                            @include('wallet::backend.wallet-history.search-result')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- payoutRequestModal Modal -->
    <div class="modal fade" id="payoutRequestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal_xl__fixed">
            <div class="popup_contents modal-content">
                <div class="popup_contents__header">
                    <div class="popup_contents__header__flex">
                        <div class="popup_contents__header__contents">
                            <h2 class="popup_contents__header__title">{{ __('Deposit To User Wallet') }}</h2>
                        </div>
                        <div class="popup_contents__header__close" data-bs-dismiss="modal">
                            <span class="popup_contents__close popup_close"> <i class="fas fa-times"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="popup_contents__body">
                    <form action="{{ route('admin.wallet.deposit.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="selected_payment_gateway" value="added_by_admin">
                        <div class="form__input__single">
                            <label for="user_id" class="info-title"> {{__('Select User')}} <span class="text-danger">*</span> </label>
                            <select name="user_id" id="user_id" class="form-control select2_activation">
                                <option value="" disabled>{{__('Select User')}}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->fullname }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form__input__single">
                            <label for="user_id" class="info-title"> {{__('Deposit Amount')}} <span class="text-danger">*</span> </label>
                           <input type="text" name="amount" class="form__control"  placeholder="{{ __('Enter Deposit Amount') }}"/>
                        </div>

                        <div class="popup_contents__footer flex_btn justify-content-end profile-border-top">
                            <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{__('Submit')}}</button>
                            <a href="javascript:void(0)" class="cmnBtn btn_5 btn_bg_danger radius-5" data-bs-dismiss="modal">{{__('Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('wallet::backend.wallet-history.history-js')
@endsection
