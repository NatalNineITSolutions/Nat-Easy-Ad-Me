@extends('backend.admin-master')
@section('site-title')
    {{__('Add New Subcategory')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/fontawesome-iconpicker.min.css')}}">
    <x-summernote.css/>
    <x-media.css/>
    <style>
        .media-upload-btn-wrapper .img-wrap {
            position: relative;
            display: inline-block;
            max-width: 30%;
        }
    </style>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Add New Subcategory')}}   </h4>
                    </div>
                    <div class="right-content">
                        <a class="cmnBtn btn_5 btn_bg_blue radius-5" href="{{route('admin.subcategory')}}">{{__('All Subcategory')}}</a>
                    </div>
                </div>
                <x-validation.error/>
                <form action="{{route('admin.subcategory.new')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form__input__flex">

                        <div class="form__input__single">
                            <label for="category_id" class="form__input__single__label">{{__('Parent Category')}}</label>
                            <select name="category_id" id="category_id" class="select2_activation radius-5">
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- NEW: Existing subcategories for selected category --}}
<div class="form__input__single" id="existing_subcats_wrapper" style="display:none;">
    <label for="existing_subcategory" class="form__input__single__label">{{__('Existing Subcategories')}}</label>
    <select id="existing_subcategory" class="select2_activation radius-5" disabled>
        <option value="">{{ __('-- Select Category First --') }}</option>
    </select>
    <small class="text-muted d-block mt-1">{{ __('These are the subcategories already created under the selected category.') }}</small>
</div>


                        <div class="form__input__single">
                            <label for="name" class="form__input__single__label">{{__('Sub Category')}}</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{__('Sub Category')}}">
                        </div>
                        <div class="form__input__single permalink_label">
                            <label class="text-dark form__input__single__label">{{__('Permalink * :')}}
                                <span id="slug_show" class="display-inline"></span>
                                <span id="slug_edit" class="display-inline">
                                     <button class="btn btn-warning btn-sm slug_edit_button"> <i class="fas fa-edit"></i> </button>
                                    <input type="text" name="slug" class="form-control subcategory_slug mt-2" style="display: none">
                                      <button class="btn btn-info btn-sm slug_update_button mt-2" style="display: none">{{__('Update')}}</button>
                                </span>
                            </label>
                        </div>
                        <div class="form__input__single">
                            <label class="form__input__single__label">{{__('Description')}}</label>
                            <input type="hidden" name="description">
                            <div class="summernote"></div>
                        </div>
                        <div class="form__input__single">
                            <label for="image" class="form__input__single__label">{{__('Upload Sub Category Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" name="image">
                                <button type="button" class="cmnBtn btn_5 btn_bg_blue radius-5 media_upload_form_btn"
                                        data-btntitle="{{__('Select Image')}}"
                                        data-modaltitle="{{__('Upload Image')}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                        </div>
                        <x-meta.meta-section/>
                    </div>
                    <div class="btn_wrapper mt-4">
                        <button type="submit" id="update" class="cmnBtn btn_5 btn_bg_blue radius-5">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-media.markup/>
@endsection
@section('scripts')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/fontawesome-iconpicker.min.js')}}"></script>
    <script>
        <x-icon.icon-picker/>
    </script>
    <x-summernote.js/>
    <x-media.js />
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                //Permalink Code
                $('.permalink_label').hide();
                $(document).on('keyup', '#name', function (e) {
                    let slug = converToSlug($(this).val());
                    let url = "{{url('/subcategory/')}}/" + slug;
                    $('.permalink_label').show();
                    let data = $('#slug_show').text(url).css('color', 'blue');
                    $('.subcategory_slug').val(slug);
                });

                function converToSlug(slug){
                    let finalSlug = slug.replace(/[^a-zA-Z0-9]/g, ' ');
                    finalSlug = slug.replace(/  +/g, ' ');
                    finalSlug = slug.replace(/\s/g, '-').toLowerCase().replace(/[^\w-]+/g, '-');
                    return finalSlug;
                }

                //Slug Edit Code
                $(document).on('click', '.slug_edit_button', function (e) {
                    e.preventDefault();
                    $('.subcategory_slug').show();
                    $(this).hide();
                    $('.slug_update_button').show();
                });

                //Slug Update Code
                $(document).on('click', '.slug_update_button', function (e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.slug_edit_button').show();
                    let update_input = $('.subcategory_slug').val();
                    let slug = converToSlug(update_input);
                    let url = `{{url('/subcategory/')}}/` + slug;
                    $('#slug_show').text(url);
                    $('.subcategory_slug').val(slug);
                    $('.subcategory_slug').hide();
                });

                // --- load existing subcategories for chosen category using your admin route
$('#category_id').on('change', function () {
    var catId = $(this).val();
    var $wrapper = $('#existing_subcats_wrapper');
    var $select  = $('#existing_subcategory');

    if (!catId) {
        $select.prop('disabled', true).html('<option value="">{{ __("-- Select Category First --") }}</option>');
        $wrapper.hide();
        return;
    }

    $wrapper.show();
    $select.prop('disabled', true).html('<option>{{ __("Loading...") }}</option>');

    $.ajax({
        url: "{{ route('admin.get.subcategory.by.category') }}", // existing admin GET route
        method: 'GET',
        data: { category_id: catId }, // route expects category_id as query param
        dataType: 'json',
        timeout: 8000,
        success: function (data) {
            if (!data || !Array.isArray(data) || data.length === 0) {
                $select.html('<option value="">{{ __("-- No subcategories --") }}</option>');
                $select.prop('disabled', true);
                return;
            }

            var options = '<option value="">{{ __("-- Select Subcategory (for info) --") }}</option>';
            $.each(data, function (i, s) {
                options += '<option value="' + s.id + '">' + s.name + '</option>';
            });

            $select.html(options).prop('disabled', false);

            // refresh select2 if used
            if ($select.hasClass('select2-hidden-accessible')) {
                try { $select.trigger('change.select2'); } catch(e) {}
            }
            console.info('Loaded subcategories for category:', catId);
        },
        error: function (xhr) {
            $select.html('<option value="">{{ __("Error loading") }}</option>');
            $select.prop('disabled', true);
            console.error('Ajax error loading subcategories:', {
                status: xhr.status,
                statusText: xhr.statusText,
                body: xhr.responseText
            });
        }
    });
});

// auto-load if category is already selected on page load
var preselected = $('#category_id').val();
if (preselected) {
    $('#category_id').trigger('change');
}

$('#existing_subcategory').select2({
    disabled: true,
    minimumResultsForSearch: Infinity // hide search bar
});

            });
        })(jQuery)
    </script>
@endsection