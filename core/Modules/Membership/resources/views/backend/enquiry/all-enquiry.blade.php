@extends('backend.admin-master')
@section('site-title')
    {{ __('All Enquiries') }}
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <div class="dashboard__inner__header__flex">
                        <div class="dashboard__inner__header__left">
                            <h4 class="dashboard__inner__header__title">{{ __('All Enquiries') }}</h4>
                            @can('enquiry-form-bulk-delete')
                                <x-bulk-action.bulk-action/>
                            @endcan
                        </div>
                        <div class="dashboard__inner__header__right">
                            <div class="d-flex text-right w-100 mt-3">
                                <input class="form__control" name="string_search" id="string_search" placeholder="{{ __('Search') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <x-validation.error/>
                <div class="tableStyle_three mt-4">
                    <div class="table_wrapper custom_Table">
                        <div class="custom_table style-04 search_result">
                            @include('membership::backend.enquiry.search-result')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @can('enquiry-form-bulk-delete')
        <x-bulk-action.bulk-delete-js :url="route('admin.enquiry.form.delete.bulk.action')"/>
    @endcan
    @include('membership::backend.enquiry.enquiry-js')
@endsection
