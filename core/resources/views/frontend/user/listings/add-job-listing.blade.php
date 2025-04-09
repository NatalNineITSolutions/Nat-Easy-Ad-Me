@extends('frontend.layout.master')
@section('title', __('Job Seeker Profile'))

@section('style')
    <x-media.css />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .new_image_add_listing .attachment-preview {
            width: 200px;
            height: 200px;
            border-radius: 6px;
            overflow: hidden;
        }

        .new_image_add_listing .attachment-preview .thumbnail .centered img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
        }

        button.btn.btn-info.media_upload_form_btn {
            background-color: rgb(239, 246, 255);
            border: none;
            color: rgb(59, 130, 246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }

        /* Image upload preview styles */
        .media-upload-btn-wrapper .img-wrap {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .media-upload-btn-wrapper .img-wrap .rmv-span {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            cursor: pointer;
            font-size: 12px;
        }

        .uploaded-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .uploaded-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            object-fit: cover;
        }

        .delete-image-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            padding: 2px 6px;
            font-size: 12px;
        }

        .delete-image-btn:hover {
            background: darkred;
        }

        /* Style for date input to match other fields */
        input[type="date"].form-control {
            height: 45px;
            padding: 10px 15px;
            font-size: 14px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        input[type="date"].form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .card-header {
            border-radius: 8px 8px 0 0 !important;
            padding: 15px 20px;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            padding: 10px 30px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 45px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Create Your Job Seeker Profile</h1>

        <form method="POST" action="{{ route('user.addjob.listing') }}" enctype="multipart/form-data">
            @csrf

            <!-- Personal Information Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Personal Information</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="dob" class="form-control"
                                max="{{ date('Y-m-d', strtotime('-18 years')) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Current Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Profile Picture <span class="text-danger">*</span></label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap new_image_add_listing">
<<<<<<< HEAD
                                    <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                </div>
                                <input type="hidden" name="image" id="images_input">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                    data-btntitle="{{ __('Select Image') }}" 
                                    data-modaltitle="{{ __('Upload Image') }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#media_upload_modal"
                                    data-mulitple="true">
=======
                                    <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images"
                                        class="w-100">
                                </div>
                                <input type="hidden" name="image" id="images_input">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                    data-btntitle="{{ __('Select Image') }}" data-modaltitle="{{ __('Upload Image') }}"
                                    data-bs-toggle="modal" data-bs-target="#media_upload_modal" data-mulitple="true">
>>>>>>> feature/job_seekers
                                    {{ __('Upload Profile Picture') }}
                                </button>
                                <small>{{ __('image format: jpg, jpeg, png, gif, webp') }}</small>
                            </div>
                            <div class="uploaded-images mt-3" id="uploaded-images-container">
                                <!-- Preview of uploaded images will appear here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Section -->
            <!-- Location Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Location Information</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <select name="country_id" id="country_id" class="form-control select2" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <select name="state_id" id="state_id" class="form-control select2" required>
                                <option value="">Select State</option>
                                <!-- States will be loaded via AJAX -->
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <select name="city_id" id="city_id" class="form-control select2" required>
                                <option value="">Select City</option>
                                <!-- Cities will be loaded via AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Preferences Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Job Preferences</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <input type="hidden" name="sub_category_id" value="107">
                        <div class="col-md-12">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <select name="child_category_id" id="child_category_id" class="form-control select2" required>
                                <option value="">Select Job Type</option>
                                @if(isset($specific_subcategory) && $specific_subcategory->childcategories->isNotEmpty())
                                    @foreach($specific_subcategory->childcategories as $childcategory)
                                        <option value="{{ $childcategory->id }}">{{ $childcategory->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resume/CV Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Resume Information</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Work Experience <span class="text-danger">*</span></label>
                        <input type="text" name="work_experience" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Education <span class="text-danger">*</span></label>
                        <input type="text" name="education" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills <span class="text-danger">*</span></label>
                        <input type="text" name="skills" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Certifications</label>
                            <input type="text" name="certifications" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Achievements</label>
                            <input type="text" name="achievements" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <textarea name="projects" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Professional Summary <span class="text-danger">*</span></label>
                        <textarea name="summary" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Portfolio Links (GitHub, LinkedIn, etc.)</label>
                        <input type="text" name="portfolio_links" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Application Details Section -->
            <div class="card mb-4">
                <div class="card-header text-white">
                    <h2 class="h5 mb-0">Application Details</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Available From <span class="text-danger">*</span></label>
                            <input type="date" name="availability_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Work Preference <span class="text-danger">*</span></label>
                            <select name="work_preference" class="form-control select2" required>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="onsite">On-site</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expected Salary <span class="text-danger">*</span></label>
                            <input type="number" name="expected_salary" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Willing to Relocate? <span class="text-danger">*</span></label>
                            <select name="relocation_willingness" class="form-control select2" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Work Authorization/Visa Status <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="work_authorization" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Submit Profile</button>
            </div>
        </form>
    </div>

    <x-media.markup type="web" />
@endsection

@section('scripts')
    <x-media.js type="web" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Media upload handling
            $(document).on('media_upload_selected', function (e, data) {
                if (data.trigger_button.hasClass('media_upload_form_btn')) {
                    let wrapper = data.trigger_button.closest('.media-upload-btn-wrapper');
                    let imagesInput = wrapper.find('input[name="image"]');

                    // Get current value as array (or empty array if no value)
                    let currentValue = imagesInput.val() ? imagesInput.val().split('|') : [];

                    // Add new image ID if not already present
                    if (!currentValue.includes(data.id.toString())) {
                        currentValue.push(data.id);
                        imagesInput.val(currentValue.join('|'));

                        // Update preview container
                        let previewContainer = $('#uploaded-images-container');

                        // Create new image preview
                        let newImage = $(`
<<<<<<< HEAD
                            <div class="image-container">
                                <img src="${data.url}" class="uploaded-image" alt="${data.name}">
                                <button type="button" class="delete-image-btn" data-id="${data.id}">×</button>
                            </div>
                        `);
=======
                                                            <div class="image-container">
                                                                <img src="${data.url}" class="uploaded-image" alt="${data.name}">
                                                                <button type="button" class="delete-image-btn" data-id="${data.id}">×</button>
                                                            </div>
                                                        `);
>>>>>>> feature/job_seekers

                        previewContainer.append(newImage);

                        // Update main preview to show the first image
                        if (currentValue.length === 1) {
                            wrapper.find('.new_image_add_listing').html(`
<<<<<<< HEAD
                                <div class="attachment-preview">
                                    <div class="thumbnail">
                                        <div class="centered">
                                            <img src="${data.url}" alt="${data.name}">
                                        </div>
                                    </div>
                                </div>
                            `);
=======
                                                                <div class="attachment-preview">
                                                                    <div class="thumbnail">
                                                                        <div class="centered">
                                                                            <img src="${data.url}" alt="${data.name}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            `);
>>>>>>> feature/job_seekers
                        }
                    }
                }
            });

            // Handle image deletion
            $(document).on('click', '.delete-image-btn', function () {
                let imageId = $(this).data('id');
                let wrapper = $(this).closest('.media-upload-btn-wrapper');
                let imagesInput = wrapper.find('input[name="image"]');
                let currentValue = imagesInput.val() ? imagesInput.val().split('|') : [];

                // Remove the image ID
                currentValue = currentValue.filter(id => id != imageId);
                imagesInput.val(currentValue.join('|'));

                // Remove the preview
                $(this).parent().remove();

                // Update main preview if needed
                if (currentValue.length === 0) {
                    wrapper.find('.new_image_add_listing').html(`
<<<<<<< HEAD
                        <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                    `);
=======
                                                        <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                                    `);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                width: '100%'
            });

            // Country change event
            $('#country_id').on('change', function () {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: "{{ route('au.state.all') }}",
                        type: "POST",
                        data: {
                            country: countryId, // Note: using 'country' as parameter name
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#state_id').empty();
                                $('#state_id').append('<option value="">Select State</option>');
                                $.each(response.states, function (index, state) {
                                    $('#state_id').append('<option value="' + state.id + '">' + state.state + '</option>');
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching states:', error);
                            $('#state_id').empty();
                            $('#state_id').append('<option value="">Select State</option>');
                        }
                    });
                } else {
                    $('#state_id').empty();
                    $('#state_id').append('<option value="">Select State</option>');
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
                }
            });

            // State change event
            $('#state_id').on('change', function () {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: "{{ route('au.city.all') }}",
                        type: "POST",
                        data: {
                            state: stateId, // Note: using 'state' as parameter name
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#city_id').empty();
                                $('#city_id').append('<option value="">Select City</option>');
                                $.each(response.cities, function (index, city) {
                                    $('#city_id').append('<option value="' + city.id + '">' + city.city + '</option>');
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching cities:', error);
                            $('#city_id').empty();
                            $('#city_id').append('<option value="">Select City</option>');
                        }
                    });
                } else {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
>>>>>>> feature/job_seekers
                }
            });
        });
    </script>
@endsection