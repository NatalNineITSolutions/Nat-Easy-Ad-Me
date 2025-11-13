@extends('backend.admin-master')
@section('site-title')
    {{__('Add New Child Category')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <x-summernote.css/>
    <x-media.css/>
@endsection
@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-6 col-lg-6 mt-0">
            <div class="dashboard__card bg__white padding-20 radius-10">
                <div class="header-wrap d-flex justify-content-between mb-3">
                    <div class="left-content">
                        <h4 class="header-title">{{__('Add New Child Category')}}   </h4>
                    </div>
                    <div class="right-content">
                        <a class="cmnBtn btn_5 btn_bg_info radius-5" href="{{route('admin.child.category')}}">{{__('All Child Categories')}}</a>
                    </div>
                </div>
                <x-validation.error/>
                <form action="{{route('admin.child.category.new')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form__input__flex">
                        <div class="form__input__single">
                            <label for="category" class="form__input__single__label"> {{__('Select Parent Category')}} <span class="text-danger">*</span> </label>
                            <select name="category_id" id="category" class="select2_activation radius-5">
                                <option value="">{{__('Select Category')}}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form__input__single">
                            <label for="subcategory" class="form__input__single__label"> {{__('Select Sub Category')}} <span class="text-danger">*</span> </label>
                            <select  name="sub_category_id" id="subcategory" class="select2_activation form__control radius-5 subcategory">
                                <option value="">{{__('Select Sub Category')}}</option>
                            </select>
                        </div>

                        {{-- Existing child categories for selected subcategory (view-only) --}}
<div class="form__input__single" id="existing_childcats_wrapper" style="display:none;">
    <label for="existing_childcategory" class="form__input__single__label">{{ __('Existing Child Categories') }}</label>
    <select id="existing_childcategory" class="select2_activation radius-5">
        <option value="">{{ __('-- Select Sub Category First --') }}</option>
    </select>
    <small class="text-muted d-block mt-1">{{ __('These are the child categories already created under the selected subcategory.') }}</small>
</div>

                        <div class="form__input__single">
                            <label for="name" class="form__input__single__label">{{__('Child Category')}}</label>
                            <input type="text" class="form__control radius-5" name="name" id="name" placeholder="{{__('Child Category Name')}}">
                        </div>
                        <div class="form__input__single permalink_label">
                            <label class="form__input__single__label">{{__('Permalink * :')}}
                                <span id="slug_show" class="display-inline"></span>
                                <span id="slug_edit" class="display-inline">
                                  <button class="btn btn-warning btn-sm slug_edit_button"> <i class="fas fa-edit"></i> </button>
                                  <input type="text" name="slug" class="form__control radius-5 child_category_slug mt-2" style="display: none">
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
                            <label for="image" class="form__input__single__label">{{__('Upload Child Category Image')}}</label>
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
    <x-summernote.js/>
    <x-media.js />
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                //Permalink Code
                $('.permalink_label').hide();
                $(document).on('keyup', '#name', function (e) {
                    var slug = converToSlug($(this).val());
                    var url = "{{url('/child-category/')}}/" + slug;
                    $('.permalink_label').show();
                    $('#slug_show').text(url).css('color', 'blue');
                    $('.child_category_slug').val(slug);
                });

                function converToSlug(slug){
                    let s = slug.replace(/[^a-zA-Z0-9]/g, ' ');
                    s = s.replace(/  +/g, ' ');
                    s = s.replace(/\s/g, '-').toLowerCase().replace(/[^\w-]+/g, '-');
                    return s;
                }

                // Slug Edit / Update
                $(document).on('click', '.slug_edit_button', function (e) {
                    e.preventDefault();
                    $('.child_category_slug').show();
                    $(this).hide();
                    $('.slug_update_button').show();
                });

                $(document).on('click', '.slug_update_button', function (e) {
                    e.preventDefault();
                    $(this).hide();
                    $('.slug_edit_button').show();
                    var update_input = $('.child_category_slug').val();
                    var slug = converToSlug(update_input);
                    var url = `{{url('/child-category/')}}/` + slug;
                    $('#slug_show').text(url);
                    $('.child_category_slug').val(slug).hide();
                });

                // select category -> load subcategories (POST route you already use)
                $('#category').on('change', function(){
                    var category_id = $(this).val();
                    $.ajax({
                        method:'post',
                        url:"{{route('admin.select.subcategory')}}",
                        data:{category_id:category_id, _token: '{{ csrf_token() }}'},
                        success:function(res){
                            if(res.status=='success'){
                                var alloptions = '<option value="">{{ __("Select Sub Category") }}</option>';
                                var allSubCategory = res.sub_categories;
                                $.each(allSubCategory,function(index,value){
                                    alloptions +="<option value='" + value.id + "'>" + value.name + "</option>";
                                });
                                $(".subcategory").html(alloptions);
                                // update niceSelect or select2 if used
                                try { $('#subcategory').niceSelect('update'); } catch(e){}
                                try { $('#subcategory').trigger('change.select2'); } catch(e){}
                                // trigger change to load existing child categories for preselected subcategory
                                $('#subcategory').trigger('change');
                            }
                        },
                        error: function(xhr){
                            console.error('Error loading subcategories for category:', xhr.status, xhr.responseText);
                        }
                    });
                });

                
               // load existing child categories when subcategory changes (view-only but openable)
$('#subcategory').on('change', function () {
    var subId = $(this).val();
    var $wrapper = $('#existing_childcats_wrapper');
    var $select  = $('#existing_childcategory');

    if (!subId) {
        $select.prop('disabled', true).html('<option value="">{{ __("-- Select Sub Category First --") }}</option>');
        $wrapper.hide();
        return;
    }

    $wrapper.show();
    // make it openable — show loading then enable to allow opening
    $select.prop('disabled', false).html('<option>{{ __("Loading...") }}</option>');

    $.ajax({
        url: "{{ route('admin.get.childcategory.by.subcategory') }}",
        method: 'GET',
        data: { sub_category_id: subId },
        dataType: 'json',
        success: function (data) {
            // data expected as array [{id,name}, ...]
            if (!data || !Array.isArray(data) || data.length === 0) {
                $select.html('<option value="">{{ __("-- No child categories --") }}</option>');
                // keep it non-interactive if empty
                $select.prop('disabled', true);
                // update plugin UI
                try { $select.niceSelect('update'); } catch(e){}
                try { $select.trigger('change.select2'); } catch(e){}
                return;
            }

            var options = '<option value="">{{ __("-- Select Child Category (for info) --") }}</option>';
            $.each(data, function (i, s) {
                options += '<option value="' + s.id + '">' + s.name + '</option>';
            });

            $select.html(options);
            // enable so user can open and view options
            $select.prop('disabled', false);

            // update niceSelect/select2 if used:
            try { $select.niceSelect('update'); } catch(e){}
            try { $select.trigger('change.select2'); } catch(e){}

            // store the current selection index so we can revert if user changes it
            $select.data('lockedIndex', $select.prop('selectedIndex'));
        },
        error: function (xhr) {
            $select.html('<option value="">{{ __("Error loading") }}</option>');
            $select.prop('disabled', true);
            console.error('Ajax error loading child categories:', xhr.status, xhr.responseText);
        }
    });
});

// ---- make existing_childcategory openable but not changeable ----
(function(){
  var $viewOnly = $('#existing_childcategory');

  // remember index on mousedown/focus (covers mouse and keyboard)
  $viewOnly.on('focus mousedown', function(){
    $(this).data('lockedIndex', this.selectedIndex);
  });

  // revert selection immediately if changed
  $viewOnly.on('change', function(){
    var locked = $(this).data('lockedIndex');
    if (typeof locked !== 'undefined') {
      var that = this;
      setTimeout(function(){
        that.selectedIndex = locked;
        // refresh plugin UI if needed
        if ($(that).hasClass('nice-select')) {
          try { $(that).niceSelect('update'); } catch(e) {}
        }
        if ($(that).hasClass('select2-hidden-accessible')) {
          try { $(that).trigger('change.select2'); } catch(e) {}
        }
      }, 0);
    }
  });

  // prevent arrow keys from changing selection (allows Tab/Enter)
  $viewOnly.on('keydown', function(e){
    if ([9,13].indexOf(e.keyCode) === -1) {
      e.preventDefault();
    }
  });
})();
  
// auto-load on page load if category/subcategory preselected
var preCategory = $('#category').val();
if (preCategory) {
    $('#category').trigger('change');
} else {
    var preSub = $('#subcategory').val();
    if (preSub) {
        $('#subcategory').trigger('change');
    }
}


            });
        })(jQuery)
    </script>
@endsection
