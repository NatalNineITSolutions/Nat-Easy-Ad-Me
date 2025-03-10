@extends('backend.admin-master')
@section('site-title')
    {{ __('All membership') }}
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
                            <h4 class="dashboard__inner__header__title">{{ __('All membership') }}</h4>
                            @can('membership-bulk-delete')
                                <x-bulk-action.bulk-action/>
                            @endcan
                        </div>
                        <div class="dashboard__inner__header__right">
                            @can('membership-add')
                                <a href="{{ route('admin.membership.add') }}"
                                   class="cmnBtn btn_5 btn_bg_blue radius-5">
                                    <span class="btn_plus_icon me-1"><i class="fa-solid fa-plus"></i></span>
                                    {{ __('Add New membership') }}
                                </a>
                            @endcan
                            <div class="d-flex text-right w-100 mt-3">
                                <input class="form__control blog_string_search" name="string_search" id="string_search" placeholder="{{ __('Search') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <x-notice.general-notice :description="__('Notice: A membership can be deleted if it has no dependencies. Specifically, it can be removed only if it is not associated with any user.')" />
                <x-validation.error />
            <div class="custom_table style-04 search_result">
                @include('membership::backend.membership.search-result')
            </div>
        </div>
     </div>
    </div>
    <x-media.markup/>
@endsection
@section('scripts')
    @can('membership-bulk-delete')
        <x-bulk-action.bulk-delete-js :url="route('admin.membership.delete.bulk.action')"/>
    @endcan
    <x-media.js/>
    @include('membership::backend.membership.membership-js')
@endsection
