@extends('backend.admin-master')

@section('site-title')
    {{ __('Branch Commission') }}
@endsection

@section('style')
    <x-media.css/>
@endsection

@section('content')
<div class="row g-4 mt-0">
    <div class="col-xl-8 col-lg-8 mt-0">
        <div class="dashboard__card bg__white padding-20 radius-10">
            <h2 class="dashboard__card__header__title mb-3">{{ __('Branch Commission') }}</h2>
            <x-validation.error/>

            <form action="{{ route('admin.general.branch.commission') }}" method="POST" class="validateForm">
                @csrf
                <div class="form__input__flex">
                    {{-- Example Branch Commission Field --}}
             

                    <div class="form__input__single">
                        <label for="branch_commission" class="form__input__single__label">{{ __('Commission (%)') }}</label>
                        <input type="number" step="0.01" min="0"
       name="branch_commission"
       id="branch_commission"
       value="{{ old('branch_commission', get_static_option('Branch')) }}"
       class="form__control radius-5"
       placeholder="{{ __('Enter Commission Value') }}">              
                    </div>

                    {{-- Add more branches as needed --}}
                </div>

                <div class="btn_wrapper mt-4">
                    <button type="submit" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Update Commission') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-media.markup/>
@endsection

@section('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            <x-btn.update/>
        });
    }(jQuery));
</script>
@endsection
