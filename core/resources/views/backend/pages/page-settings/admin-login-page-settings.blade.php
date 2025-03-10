@extends('backend.admin-master')
@section('site-title')
    {{__('Admin Login Page Settings')}}
@endsection
@section('style')
    <x-media.css/>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <x-validation.error/>
        <form action="{{route('admin.login.page.settings')}}" method="POST">
            @csrf

             <div class="col-6">
                <div class="dashboard__card bg__white padding-20 radius-10">
                    <h2 class="dashboard__card__header__title mb-3">{{__('Admin Login Page Settings')}}</h2>

                    <div class="form__input__single">
                        <label for="admin_login_page_title" class="form__input__single__label">{{ __('Title') }}</label>
                        <input type="text" class="form__control radius-5" name="admin_login_page_title"  value="{{get_static_option('admin_login_page_title')}}">
                    </div>
                    <div class="form__input__single">
                        <label for="admin_login_page_subtitle" class="form__input__single__label">{{ __('Sub Title') }}</label>
                        <input type="text" class="form__control radius-5" name="admin_login_page_subtitle" id="admin_login_page_subtitle" value="{{get_static_option('admin_login_page_subtitle')}}">
                    </div>

                    <div class="form__input__single">
                        <label for="og_meta_image" class="form__input__single__label">{{__('Background Image')}}</label>
                        <div class="media-upload-btn-wrapper">
                            <div class="img-wrap">
                                @php
                                    $bg_image = get_attachment_image_by_id(get_static_option('admin_login_page_background_image'),null,true);
                                    $btn_label =__( 'Upload Image');
                                @endphp
                                @if(!empty($bg_image))
                                    <div class="attachment-preview">
                                        <div class="thumbnail">
                                            <div class="centered">
                                                <img class="avatar user-thumb" src="{{$bg_image['img_url']}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    @php  $btn_label = __('Change Image'); @endphp
                                @endif
                            </div>
                            <input type="hidden" id="admin_login_page_background_image" name="admin_login_page_background_image" value="{{get_static_option('admin_login_page_background_image')}}">
                            <button type="button" class="btn btn-info media_upload_form_btn"
                                    data-btntitle="{{__('Select Image')}}"
                                    data-modaltitle="{{__('Upload Image')}}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#media_upload_modal">
                                {{__($btn_label)}}
                            </button>
                        </div>
                        <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png,webp, Recommended image size 1920x600')}}</small>
                    </div>
                </div>
            </div>
            <div class="btn_wrapper mt-4">
                <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Update Changes') }}</button>
            </div>
        </form>
    </div>
    <x-media.markup/>
@endsection
@section('scripts')
    <x-media.js/>
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                <x-btn.update/>
            });
        }(jQuery));
    </script>
@endsection
