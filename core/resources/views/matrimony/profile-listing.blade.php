@extends('matrimony.layouts.app')

@section('style')
    <style>
        .profile-container {
            background-color: #FFFBEE;
            padding-top: 45px;
        }

        #profileForm {
            margin-top: 35px;
        }

        .main {
            border: 1px solid #F0F0F0;
            border-radius: 20px;
            padding: 10px 20px;
            margin-bottom: 30px;
        }

        .main h3 {
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            color: #66451C;
            margin-top: 25px;
        }

        /* Add this to your CSS file */
        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
            margin-right: 10px;
        }

        .form-switch .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        #visibilityLabel {
            font-weight: semibold;
        }

        form {
            margin-top: 30px;
        }

        form label {
            font-size: 12px;
            font-weight: 600;
        }

        form input {
            font-size: 12px;
            font-weight: 500;
        }

        .form-control {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1.2px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        /* Upload */
        .upload-box {
            border: 2px dashed #90119B;
            border-radius: 10px;
            background-color: #F9F9F9;
        }

        .upload-icon {
            width: 50px;
        }

        .upload-text {
            font-weight: bold;
        }

        .browse-text {
            color: #B000B5;
            cursor: pointer;
        }

        .upload-btn {
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .drive-btn {
            background: #F0F0F0;
            color: #000;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 12px;
        }

        .browse-btn {
            background: #E9D5FF;
            color: #6B21A8;
        }

        .cancel-button {
            background-color: #E0E0E0;
            color: #000;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: none;
        }

        .done-button {
            background-color: #FF0066;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            border: none;
        }

        .upload-area p {
            font-size: 14px;
            font-weight: 600;
            margin-top: 12px;
        }

        .uploaded-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
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

        .text-muted {
            font-size: 13px;
            font-weight: 600;
        }

        .form-select {
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        /* Media Upload Modal Styles */
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

        .btn-info.media_upload_form_btn {
            background-color: rgb(239, 246, 255);
            border: none;
            color: rgb(59, 130, 246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }
    </style>
    <x-media.css />
@endsection

@section('content')
    <div>
        @include('matrimony.partials.banner')
    </div>
    <div class="profile-container">
        <div class="container ">
            <div class="row gx-3">
                @include('matrimony.partials.sidebar') <!-- Include the sidebar -->

                <main class="col-md-8 col-lg-9 px-md-4">
                    <div class="main">
                        <h3>Let's showcase the groom's or bride's details</h3>

                        <div id="profileForm" aria-label="Profile Listing Form">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Religion</label>
                                    <select class="form-select" name="religion" id="religion">
                                        <option value="" selected>Choose Religion</option>
                                        @foreach($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->religion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" class="form-control"
                                        placeholder="Enter Occupation" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="annual_income" class="form-label">Annual Income</label>
                                    <input type="number" id="annual_income" name="annual_income" class="form-control"
                                        placeholder="Enter Annual Income" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Caste</label>
                                    <select class="form-select" name="caste" id="caste">
                                        <option value="" selected>Choose Caste</option>
                                        @foreach($castes as $caste)
                                            <option value="{{ $caste->id }}">{{ $caste->caste }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="motherTongue" class="form-label">Mother Tongue</label>
                                    <select class="form-select" id="motherTongue" name="motherTongue" required>
                                        <option value="" selected>Choose Mother Tongue</option>
                                        @foreach($motherTongues as $tongue)
                                            <option value="{{ $tongue->mother_tongue }}">{{ $tongue->mother_tongue }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Zodiac Sign</label>
                                    <select class="form-select" name="zodiac_sign" id="zodiac_sign" required>
                                        <option value="" selected disabled>Choose Zodiac Sign</option>
                                        @foreach($zodiacsign as $zodiac)
                                            <option value="{{ $zodiac->id }}">{{ $zodiac->zodiac_sign }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="star" class="form-label">Star</label>
                                    <select class="form-select" id="star" name="star" required>
                                        <option value="" selected disabled>Choose Star</option>
                                        @foreach($stars as $star)
                                            <option value="{{ $star->id }}">{{ $star->star }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="marital_status" class="form-label">Marital Status</label>
                                    <select class="form-select" id="marital_status" name="marital_status" required>
                                        <option value="" selected disabled>Choose Marital Status</option>
                                        @foreach($marital_status as $status)
                                            <option value="{{ $status }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
        <label class="form-label">Country</label>
        <select class="form-select" id="country" name="country" required>
            <option value="">Choose Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
            @endforeach
        </select>
    </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3">
        <label class="form-label">State</label>
        <select class="form-select" id="state" name="state" required>
            <option value="">Choose State</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">District</label>
        <select class="form-select" id="district" name="district" required>
            <option value="">Choose District</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">City</label>
        <select class="form-select" id="city" name="city" required>
            <option value="">Choose City</option>
        </select>
    </div>

                                <div class="col-md-4">
                                    <label class="form-label">Profile Visibility</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="visibilityToggle"
                                            name="visibility" value="1">
                                        <label class="form-check-label" for="visibilityToggle">
                                            <span id="visibilityLabel">Public</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="address box-shadow1 p-24">
                                    @if(get_static_option('google_map_settings_on_off') == null)
                                    <div class="address-wraper">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="country">
                                                    <label for="country">{{ __('Select Your Country') }}</label>
                                                    <select name="country_id" id="country_id" class="select2_activation">
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach($all_countries as $country)
                                                            <option value="{{ $country->id }}" @if(Auth::guard('web')->check() && $country->id == Auth::guard('web')->user()->country_id) selected @endif>{{ $country->country }}</option>
                                                        @endforeach
                                                    </select><br>
                                                    <span class="country_info"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="country">
                                                    <label for="country">{{ __('Select Your State') }}</label>
                                                    <select name="state_id" id="state_id" class="get_country_state select2_activation">
                                                        <option value="">{{ __('Select State') }}</option>
                                                        @foreach($all_states as $state)
                                                            <option value="{{ $state->id }}" @if(Auth::guard('web')->check() && $state->id == Auth::guard('web')->user()->state_id) selected @endif>{{ $state->state }}</option>
                                                        @endforeach
                                                    </select> <br>
                                                    <span class="state_info"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="country">
                                                    <label for="country">{{ __('Select Your City') }}</label>
                                                    <select name="city_id" id="city_id" class="get_state_city select2_activation">
                                                        <option value="">{{ __('Select City') }}</option>
                                                        @foreach($all_cities as $city)
                                                            <option value="{{ $city->id }}" @if($city->id == Auth::guard('web')->user()->city_id) selected @endif>{{ $city->city }}</option>
                                                        @endforeach
                                                    </select><br>
                                                    <span class="city_info"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <!--Google Map -->
                                        <div class="location-map mt-3">
                                            <div class="input-form input-form2">
                                                <div class="map-warper dark-support rounded overflow-hidden">
                                                    <input id="pac-input" class="controls rounded" type="text" placeholder="{{ __('Search your location')}}"/>
                                                    <div id="map_canvas" style="height: 480px"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="address-text mt-3">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                        <label for="address-text">{{ __('Address') }}</label>
                                        <input type="text" class="w-100 input-filed" name="address" id="user_address" value="{{ old('address') }}" placeholder="{{__('Address')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Upload Images</label>
                                    <p class="text-muted">Please upload files in jpg, jpeg, or png format and make sure the
                                        file size is under 25 MB. You can upload multiple images.</p>

                                    <!-- Single Upload Section for Multiple Images -->
                                    <div class="upload-img text-center"> 
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap new_image_add_listing">
                                                <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}"
                                                    alt="images" class="w-100">
                                            </div>
                                            <input type="hidden" name="image" id="images_input">
                                            <button type="button" class="btn btn-info media_upload_form_btn"
                                                data-btntitle="{{__('Select Images')}}"
                                                data-modaltitle="{{__('Upload Images')}}" data-mulitple="true"
                                                data-bs-toggle="modal" data-bs-target="#media_upload_modal">
                                                {{ __('Click to Upload Images') }}
                                            </button>
                                            <small>{{ __('image format: jpg,jpeg,png,gif,webp')}}</small> <br>
                                            <small>{{ __('recommended size 810x450') }}</small>
                                        </div>
                                        <div class="uploaded-images mt-3" id="uploaded-images-container">
                                            <!-- Preview of uploaded images will appear here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control"
                                        placeholder="Enter description"></textarea>
                                </div>
                            </div>

                            @php
                                if (Auth::check() && Auth::guard('web')->user()) {
                                    $modalTarget = '#paymentGatewayModal';
                                }
                                $buttonText = __('Sumbit');
                            @endphp
                            <button class="cmn-btn-outline1 choose_membership_plan btn btn-primary" data-bs-toggle="modal"
                                data-id="" data-price="{{ get_static_option('matrimony_price') }}"
                                data-bs-target="{{ $modalTarget }}">
                                {{ $buttonText }}
                            </button>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection

@include('matrimony.partials.gateway-markup')
<x-media.markup :type="'web'" />

@section('script')
    @if(!empty(get_static_option('google_map_settings_on_off')))
        <x-map.google-map-api-key-set />
        <x-map.google-map-listing-js />
    @endif
    {{-- Toaster initialization --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };
    </script>

    {{-- Media Upload Script --}}
    <x-media.js :type="'web'" />
    <script>
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
                                                                                        <div class="image-container">
                                                                                            <img src="${data.url}" class="uploaded-image" alt="${data.name}">
                                                                                            <button type="button" class="delete-image-btn" data-id="${data.id}">×</button>
                                                                                        </div>
                                                                                    `);

                    previewContainer.append(newImage);

                    // Update main preview to show the first image
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
                                                                                    <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                                                                `);
            }
        });
    </script>

    {{-- Store function --}}
    <script>
        document.getElementById('visibilityToggle').addEventListener('change', function () {
            const label = document.getElementById('visibilityLabel');
            if (this.checked) {
                label.textContent = 'Private';
            } else {
                label.textContent = 'Public';
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            const profileForm = document.getElementById('profileForm');
            const chooseMembershipBtn = document.querySelector('.choose_membership_plan');

            chooseMembershipBtn.addEventListener('click', function () {
                const requiredFields = ['name', 'date_of_birth', 'gender', 'religion', 'occupation',
                    'annual_income', 'caste', 'motherTongue', 'country', 'state', 'city',
                    'description', 'zodiac_sign', 'star', 'marital_status'
                ];

                let missingFields = [];
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input || !input.value.trim()) {
                        missingFields.push(field);
                    }
                });

                // Check if at least one image is uploaded
                const imagesInput = document.getElementById('images_input');
                if (!imagesInput || !imagesInput.value) {
                    missingFields.push('image');
                }

                if (missingFields.length > 0) {
                    toastr.error('Please fill all required fields including at least one image.', 'Validation Error');
                    return false;
                }

                const visibilityToggle = document.getElementById('visibilityToggle');

                // Populate hidden fields in the modal form
                document.getElementById('modal_name').value = document.getElementById('name').value;
                document.getElementById('modal_date_of_birth').value = document.getElementById('date_of_birth').value;
                document.getElementById('modal_gender').value = document.getElementById('gender').value;
                document.getElementById('modal_religion').value = document.getElementById('religion').value;
                document.getElementById('modal_occupation').value = document.getElementById('occupation').value;
                document.getElementById('modal_annual_income').value = document.getElementById('annual_income').value;
                document.getElementById('modal_caste').value = document.getElementById('caste').value;
                document.getElementById('modal_motherTongue').value = document.getElementById('motherTongue').value;
                document.getElementById('modal_country').value = document.getElementById('country').value;
                document.getElementById('modal_state').value = document.getElementById('state').value;
                document.getElementById('modal_city').value = document.getElementById('city').value;
                document.getElementById('modal_description').value = document.getElementById('description').value;
                document.getElementById('modal_images').value = imagesInput.value;
                document.getElementById('modal_zodiac_sign').value = document.getElementById('zodiac_sign').value;
                document.getElementById('modal_star').value = document.getElementById('star').value;
                document.getElementById('modal_marital_status').value = document.getElementById('marital_status').value;
                document.getElementById('modal_visibility').value = visibilityToggle.checked ? 1 : 0;
                document.getElementById('modal_address').value = document.getElementById('user_address').value;
                document.getElementById('modal_latitude').value = document.getElementById('latitude').value;
                document.getElementById('modal_longitude').value = document.getElementById('longitude').value;
            });
        });
    </script>

    {{-- Fetch country --}}
    <script>
        document.getElementById('country').addEventListener('change', function () {
    const countryId = this.value;

    const state = document.getElementById('state');
    const district = document.getElementById('district');
    const city = document.getElementById('city');

    state.innerHTML = '<option value="">Choose State</option>';
    district.innerHTML = '<option value="">Choose District</option>';
    city.innerHTML = '<option value="">Choose City</option>';

    if (!countryId) return;

    fetch(`/matrimony/get-states/${countryId}`)
        .then(res => res.json())
        .then(res => {
            res.states.forEach(item => {
                state.innerHTML += `<option value="${item.id}">${item.state}</option>`;
            });
        });
});

document.getElementById('state').addEventListener('change', function () {
    const stateId = this.value;

    const district = document.getElementById('district');
    const city = document.getElementById('city');

    district.innerHTML = '<option value="">Choose District</option>';
    city.innerHTML = '<option value="">Choose City</option>';

    if (!stateId) return;

    fetch(`/matrimony/get-districts/${stateId}`)
        .then(res => res.json())
        .then(res => {
            res.districts.forEach(item => {
                district.innerHTML += `<option value="${item.id}">${item.district}</option>`;
            });
        });
});

document.getElementById('district').addEventListener('change', function () {
    const districtId = this.value;
    const city = document.getElementById('city');

    city.innerHTML = '<option value="">Choose City</option>';

    if (!districtId) return;

    fetch(`/matrimony/get-cities/${districtId}`)
        .then(res => res.json())
        .then(res => {
            res.cities.forEach(item => {
                city.innerHTML += `<option value="${item.id}">${item.city}</option>`;
            });
        });
});


    </script>
@endsection