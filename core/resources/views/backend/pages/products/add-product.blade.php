@extends('backend.admin-master')

@section('site-title')
    {{ __('Add Product') }}
@endsection

@section('style')
    <!-- Media Modal CSS -->
    <x-media.css />

    <!-- Any additional page‐specific styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        /* Additional styles to fix media modal display */
        .modal-body .tab-content {
            padding: 15px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        
        .media-uploader-image-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 0;
            list-style: none;
        }
        
        .media-uploader-image-list li {
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .media-uploader-image-list li.selected {
            border-color: #0d6efd;
        }
        
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            min-height: 150px;
            padding: 20px;
        }
        
        .image-preloader-wrapper {
            display: none;
            text-align: center;
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-4">{{ __('Add Product') }}</h5>

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ __('Enter product name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Price (₹)') }}</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="{{ __('Enter price') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Distributor Price (₹)') }}</label>
                    <input type="number" step="0.01" name="distributor_price" class="form-control" placeholder="{{ __('Enter distributor price') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('BV Points') }}</label>
                    <input type="number" step="1" name="bv_points" class="form-control" placeholder="{{ __('Enter BV points') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Stock') }}</label>
                    <input type="number" name="stock" class="form-control" placeholder="{{ __('Available stock') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Weight (kg)') }}</label>
                    <input type="number" step="0.01" name="weight" class="form-control" placeholder="{{ __('Enter weight') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">GST (%)</label>
                    <input type="number" step="0.01" name="gst" class="form-control" placeholder="Enter GST percent" value="{{ old('gst', 0) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select name="category" class="form-control" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Description') }}</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="{{ __('Enter product description') }}"></textarea>
                </div>

                {{-- Add before submit button --}}
                <div class="upload-img text-center mt-3">
                    <div class="media-upload-btn-wrapper">
                        <div class="img-wrap new_image_add_listing">
                            <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                        </div>
                        <input type="hidden" name="image">
                        <button type="button" class="btn btn-info media_upload_form_btn"
                                data-btntitle="{{__('Select Image')}}"
                                data-modaltitle="{{__('Upload Image')}}"
                                data-bs-toggle="modal"
                                data-bs-target="#media_upload_modal">
                            {{ __('Click to browse & Upload Featured Image') }}
                        </button>
                        <small>{{ __('image format: jpg,jpeg,png,gif,webp')}}</small> <br>
                        <small>{{ __('recommended size 810x450') }}</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Save Product') }}</button>
            </form>
        </div>
    </div>

    {{-- Media Modal Markup --}}
    <x-media.markup :type="'web'" />
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Media Upload Script --}}
    <x-media.js :type="'web'" />

@endsection