@extends('backend.admin-master')
@section('site-title')
    {{ __('Listing Expiry Settings') }}
@endsection

@section('content')
<div class="col-lg-12">
    <div class="dashboard__card bg__white padding-30 radius-10">
        <h4 class="dashboard__card__header__title  mx-3 mt-2">{{ __('Set Listing Expiry Duration') }}</h4>
        <form action="{{ route('admin.listing.expiry.date') }}" method="POST">
            @csrf
            <div class="form-group mt-3  mx-3">
                <label for="expiry_days">{{ __('Expiry Duration (in days)') }}</label>
                <input type="number" name="expiry_days" id="expiry_days" class="form-control"
                       value="{{ get_static_option('listing_expiry_days') ?? 28 }}" min="1" max="365">
            </div>

            <button type="submit" class="btn btn-primary mt-3 mx-3">
                {{ __('Save Settings') }}
            </button>
        </form>
    </div>
</div>
@endsection
