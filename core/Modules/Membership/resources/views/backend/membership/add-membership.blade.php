@extends('backend.admin-master')
@section('site-title')
    {{ __('Add membership') }}
@endsection
@section('style')
    <style>
        .attr.single-input-feature-attr:not(:first-child) {
            margin-top: 15px;
        }
        .attr.single-input-feature-attr {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .single-input-feature-attr .checkbox-inline .check-input {
            height: 30px;
            width: 30px;
            margin-top: 0px;
            border-radius: 3px;
        }
        .single-input-feature-attr .checkbox-inline .check-input::after {
            font-size: 13px;
        }
    </style>
    <x-media.css />
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="dashboard__inner__header">
                    <div class="dashboard__inner__header__flex">
                        <div class="dashboard__inner__header__left">
                            <h4 class="dashboard__inner__header__title">{{ __('Add New Membership') }}</h4>
                        </div>
                    </div>
                </div>
                <x-validation.error/>
                <form action="{{route('admin.membership.add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form__input__single">
                        <label class="form__input__single__label">{{ __('membership Type') }} <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form__control select2_activation">
                            <option value="">{{ __('Select Type') }}</option>
                            @foreach($all_types as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-form.text :title="__('Title')" :required="'required'" :type="__('text')" :name="'title'" :id="'title'" :value="old('title', '')" :placeholder="__('Enter title')"/>
                    <x-form.text :title="__('Price')" :required="'required'"  :type="__('number')" :name="'price'" :id="'price'" :value="old('price', '')" :placeholder="__('Enter price')"/>
                    <x-form.text :title="__('Listings Limit')" :required="'required'"  :type="__('number')" :name="'listing_limit'" :id="'listing_limit'" :divClass="'mb-0'" :value="old('listing_limit', '')" :placeholder="__('Enter listings limit')"/>
                    <x-form.text :title="__('Images Limit')" :required="'required'"  :type="__('number')" :name="'gallery_images'" :id="'gallery_images'" :divClass="'mb-0'" :value="old('gallery_images', '')" :placeholder="__('Enter Gallery Images limit')"/>
                    <x-form.text :title="__('Featured listing Limit')" :required="'required'"  :type="__('number')" :name="'featured_listing'" :id="'featured_listing'" :divClass="'mb-0'" :value="old('featured_listing', '')" :placeholder="__('Featured listing Limit')"/>

                    <div class="form__input__single d-grid">
                        <label for="user_otp_verify_enable_disable"><strong>{{ __('Enquiry Form (Allowed/Not Allowed)') }}</strong></label>
                        <div class="switch_box style_7">
                            <input type="checkbox" name="enquiry_form" id="enquiry_form">
                            <label></label>
                        </div>
                    </div>

                    <div class="form__input__single d-grid">
                        <label for="business_hour"><strong>{{ __('Business Hour (Allowed/Not Allowed)') }}</strong></label>
                        <div class="switch_box style_7">
                            <input type="checkbox" name="business_hour" id="business_hour">
                            <label></label>
                        </div>
                    </div>

                    <div class="form__input__single d-grid">
                        <label for="membership_badge"><strong>{{ __('Membership Badge (Allowed/Not Allowed)') }}</strong></label>
                        <div class="switch_box style_7">
                            <input type="checkbox" name="membership_badge" id="membership_badge">
                            <label></label>
                        </div>
                    </div>


                    <div class="form__input__single">
                        <div id="features">
                            <div class="attr single-input-feature-attr">
                                <input name="feature[]" class="feature form-control" type="text" placeholder="{{ __('Enter feature') }}">
                                <div class="checkbox-inline style_1">
                                    <input name="status[]" type="checkbox" class="required-entry single-input-feature-checkbox check-input">
                                </div>
                                <button class="btn btn-danger btn-sm remove" type="button"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <a href="javascript:void(0)" type="button" class="cmn_btn btn_small radius-5 add mt-3">{{ __('Add Features') }}</a>
                    </div>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5 validate_membership_type">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-media.markup />
@endsection
@section('scripts')
    <x-media.js />
    @include('membership::backend.membership.membership-js')
@endsection
