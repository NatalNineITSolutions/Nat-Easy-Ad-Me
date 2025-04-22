@extends('backend.admin-master')
@section('site-title')
    {{__('All User Listings')}}
@endsection

@section('content')
    <div class="row g-4 mt-0">

        <div class="col-12">
            <form action="{{ route('admin.matrimony.profile.listing.store') }}" method="POST">
                @csrf
                <!-- <div class="mb-3">
                    <label for="price" class="form-label">{{ __('Price') }}</label>
                    <input type="number" class="form-control" id="price" name="price"
                        value="{{ get_static_option('matrimony_price', '') }}" placeholder="{{ __('Enter Price') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="bv" class="form-label">{{ __('BV Points') }}</label>
                    <input type="number" class="form-control" id="bv" name="bv"
                        value="{{ get_static_option('matrimony_bv_points', '') }}" placeholder="{{ __('Enter BV Points') }}"
                        required>
                </div> -->

                <div class="mb-3">
                    <label for="matrimony_bv_value" class="form-label">{{ __('BV Value') }}</label>
                    <input type="number" class="form-control" id="matrimony_bv_value" name="matrimony_bv_value"
                        value="{{ get_static_option('matrimony_bv_value', '') }}" placeholder="{{ __('Enter BV Value') }}"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </form>
        </div>

    </div>
@endsection