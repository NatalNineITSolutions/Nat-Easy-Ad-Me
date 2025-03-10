@extends('backend.admin-master')
@section('site-title')
    {{ __('All Types') }}
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
                            <h4 class="dashboard__inner__header__title">{{ __('All Types') }}</h4>
                            @can('membership-type-bulk-delete')
                                <x-bulk-action.bulk-action/>
                            @endcan
                        </div>
                        <div class="dashboard__inner__header__right">
                            <div class="btn-wrapper">
                                <x-btn.add-modal :title="__('Add Membership Type')" />
                            </div>
                            <div class="d-flex text-right w-100 mt-3">
                                <input class="form__control" name="string_search" id="string_search" placeholder="{{ __('Search') }}">
                            </div>
                        </div>
                    </div>
                    <x-notice.general-notice :description="__('Notice: A type can only be deleted if it has no dependencies. If a type is not associated with any subscriptions, you can proceed to delete it.')" />
                </div>
                <x-validation.error/>
                <div class="tableStyle_three mt-4">
                    <div class="table_wrapper custom_Table">
                        <div class="custom_table style-04 search_result">
                            @include('membership::backend.type.search-result')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('membership::backend.type.add-modal')
    @include('membership::backend.type.edit-modal')
    <x-media.markup/>
@endsection
@section('scripts')
    @can('membership-type-bulk-delete')
        <x-bulk-action.bulk-delete-js :url="route('admin.membership.type.delete.bulk.action')"/>
    @endcan
    <x-media.js/>
    @include('membership::backend.type.type-js')
@endsection
