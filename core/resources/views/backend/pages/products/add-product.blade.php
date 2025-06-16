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

                <!-- Featured Image using Media Modal -->
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Featured Image') }}</label>
                    <div class="media-upload-btn-wrapper">
                        <div class="img-wrap featured_image_preview">
                            <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                        </div>
                        <input type="hidden" name="featured_image" id="featured_image_input">
                        <button type="button"
                                class="btn btn-info media_upload_form_btn"
                                data-btntitle="{{ __('Select Featured Image') }}"
                                data-modaltitle="{{ __('Upload Featured Image') }}"
                                data-mulitple="false"
                                data-bs-toggle="modal"
                                data-bs-target="#media_upload_modal">
                            {{ __('Click to Upload Image') }}
                        </button>
                        <small>{{ __('Image format: jpg, jpeg, png, gif, webp') }}</small><br>
                        <small>{{ __('Recommended size: 810×450') }}</small>
                    </div>
                </div>

                <!-- Gallery fallback (optional) -->
                <div class="mb-3">
                    <label class="form-label">{{ __('Gallery Images') }}</label>
                    <input type="file" name="gallery[]" class="form-control" multiple>
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

    <script>
        // When the user selects images in the media modal…
        $(document).on('media_upload_selected', function (e, data) {
            // Only target buttons in the add‑product form
            if (!data.trigger_button.hasClass('media_upload_form_btn')) return;

            const wrapper = data.trigger_button.closest('.media-upload-btn-wrapper');
            const imagesInput = wrapper.find('input[name="image"]');

            // Current IDs as an array
            let currentValue = imagesInput.val() ? imagesInput.val().split('|') : [];

            // Add the new ID if it's not already present
            if (!currentValue.includes(data.id.toString())) {
                currentValue.push(data.id);
                imagesInput.val(currentValue.join('|'));

                // Append thumbnail preview
                const previewContainer = $('#uploaded-images-container');
                const newImage = $(`
                    <div class="image-container">
                        <img src="${data.url}" class="uploaded-image" alt="${data.name}">
                        <button type="button" class="delete-image-btn" data-id="${data.id}">×</button>
                    </div>
                `);
                previewContainer.append(newImage);

                // If this is the very first image, update the big preview
                if (currentValue.length === 1) {
                    wrapper.find('.new_image_add_listing').html(`
                        <div class="attachment-preview">
                            <div class="thumbnail">
                                <div class="centered">
                                    <img src="${data.url}" alt="${data.name}">
                                </div>
                            </div>
                        </div>
                    `);
                }
            }
        });

        // Handle thumbnail‐level deletion
        $(document).on('click', '.delete-image-btn', function () {
            const imageId = $(this).data('id').toString();
            const wrapper = $(this).closest('.media-upload-btn-wrapper');
            const imagesInput = wrapper.find('input[name="image"]');
            let currentValue = imagesInput.val() ? imagesInput.val().split('|') : [];

            // Remove that ID
            currentValue = currentValue.filter(id => id !== imageId);
            imagesInput.val(currentValue.join('|'));

            // Remove the thumbnail
            $(this).parent().remove();

            // If now empty, reset the big preview
            if (currentValue.length === 0) {
                wrapper.find('.new_image_add_listing').html(`
                    <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                `);
            }
        });
    </script>
    
    {{-- <script>
        // When an image is selected in the modal...
        $(document).on('media_upload_selected', function (e, data) {
            if (!data.trigger_button.hasClass('media_upload_form_btn')) return;
            
            let wrapper = data.trigger_button.closest('.media-upload-btn-wrapper');
            let multiple = data.trigger_button.data('mulitple') == true || data.trigger_button.data('mulitple') == "true";

            // SINGLE image mode (Featured Image)
            if (!multiple) {
                // Store the ID
                wrapper.find('input[type="hidden"]').val(data.id);

                // Render preview + delete button
                wrapper.find('.featured_image_preview').html(`
                    <div class="attachment-preview position-relative">
                        <div class="thumbnail">
                            <div class="centered">
                                <img src="${data.url}" alt="${data.name}" style="max-height:200px;">
                            </div>
                        </div>
                        <button type="button"
                                class="btn btn-sm btn-danger remove-featured-image"
                                style="position:absolute;top:5px;right:5px;">
                            ×
                        </button>
                    </div>
                `);
                
                // Close the modal after selection
                $('#media_upload_modal').modal('hide');
            }
            // MULTIPLE image mode (Gallery Images)
            else {
                // For gallery images, we'll use the file input instead
                // You can extend this part if you want to use the media modal for gallery too
            }
        });

        // Remove featured image & reset placeholder
        $(document).on('click', '.remove-featured-image', function () {
            let wrapper = $(this).closest('.media-upload-btn-wrapper');
            wrapper.find('input[type="hidden"]').val('');
            wrapper.find('.featured_image_preview').html(`
                <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="featured" class="w-100">
            `);
        });

        // Enhanced Dropzone configuration
        $(document).ready(function() {
            // Initialize Dropzone if it exists on the page
            if (typeof Dropzone !== 'undefined') {
                Dropzone.autoDiscover = false;
                
                $(".dropzone").each(function() {
                    let dropzone = new Dropzone(this, {
                        dictDefaultMessage: "{{ __('Drag or Select Your Image') }}",
                        maxFiles: 50,
                        maxFilesize: 10, //MB
                        acceptedFiles: 'image/*',
                        success: function(file, response) {
                            if (file.previewElement) {
                                file.previewElement.classList.add("dz-success");
                            }
                            // Refresh media library after upload
                            setTimeout(function() {
                                $('#load_all_media_images').trigger('click');
                            }, 500);
                        },
                        error: function(file, message) {
                            if (file.previewElement) {
                                file.previewElement.classList.add("dz-error");
                                if ((typeof message !== "String") && message.error) {
                                    message = message.error;
                                }
                                for (let node of file.previewElement.querySelectorAll("[data-dz-errormessage]")) {
                                    node.textContent = message;
                                }
                            }
                        }
                    });
                });
            }

            // Toastr notifications (on session flashes or validation errors)
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
            @if($errors->any())
                toastr.error("{{ $errors->first() }}");
            @endif
        });
    </script> --}}
@endsection