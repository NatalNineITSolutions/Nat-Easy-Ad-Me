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
            background-color: rgb(239,246,255);
            border: none;
            color: rgb(59,130,246);
            outline: none;
            box-shadow: none;
            margin: auto;
        }
    </style>
    <x-media.css/>
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
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" id="age" name="age" class="form-control"
                                        placeholder="Enter Age" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" class="form-control"
                                        placeholder="Enter Occupation" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="annual_income" class="form-label">Annual Income</label>
                                    <input type="number" id="annual_income" name="annual_income" class="form-control"
                                        placeholder="Enter Annual Income" required>
                                </div>
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
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="" selected>Choose Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="" selected>Choose State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-select" id="city" name="city" required>
                                        <option value="" selected>Choose City</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Upload Image</label>
                                    <p class="text-muted">Please upload files in jpg, jpeg, or png format and make sure the
                                        file size is under 25 MB.</p>

                                    <!-- Modified Upload Section -->
                                    <div class="upload-img text-center">
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap new_image_add_listing">
                                                <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                            </div>
                                            <input type="hidden" name="image" id="image_input">
                                            <button type="button" class="btn btn-info media_upload_form_btn"
                                                    data-btntitle="{{__('Select Image')}}"
                                                    data-modaltitle="{{__('Upload Image')}}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#media_upload_modal">
                                                {{ __('Click to Upload Profile Image') }}
                                            </button>
                                            <small>{{ __('image format: jpg,jpeg,png,gif,webp')}}</small> <br>
                                            <small>{{ __('recommended size 810x450') }}</small>
                                        </div>
                                    </div>

                                    <!-- Gallery Images Section -->
                                    <div class="picture mt-3">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="upload-img text-center">
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap new_image_gallery_add_listing">
                                                            <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}" alt="images" class="w-100">
                                                        </div>
                                                        <input type="hidden" name="gallery_images" id="gallery_images_input">
                                                        <button type="button" class="btn btn-info media_upload_form_btn"
                                                                data-btntitle="{{__('Select Image')}}"
                                                                data-modaltitle="{{__('Upload Image')}}"
                                                                data-mulitple="true"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#media_upload_modal">
                                                            {{__('Click to Upload Gallery Images')}}
                                                        </button>
                                                        <small>{{ __('image format: jpg,jpeg,png,gif,webp')}}</small> <br>
                                                        <small>{{ __('recommended size 810x450') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Enter description"></textarea>
                                </div>
                            </div>

                            @php
                                if (Auth::check() && Auth::guard('web')->user()) {
                                    $modalTarget = '#paymentGatewayModal';
                                }
                                $buttonText = __('Sumbit');
                            @endphp
                            <button class="cmn-btn-outline1 choose_membership_plan btn btn-primary" data-bs-toggle="modal" data-id=""
                                data-price="{{ get_static_option('matrimony_price') }}"
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
<x-media.markup :type="'web'"/>

@section('script')
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
    <x-media.js :type="'web'"/>
    <script>
        (function($){
            "use strict";
            
            // Handle featured image selection
            $(document).on('click', '.new_image_add_listing', function(e) {
                e.preventDefault();
                let selector = $(this).closest('.media-upload-btn-wrapper').find('.media_upload_form_btn');
                selector.trigger('click');
            });

            // Handle gallery images selection
            $(document).on('click', '.new_image_gallery_add_listing', function(e) {
                e.preventDefault();
                let selector = $(this).closest('.media-upload-btn-wrapper').find('.media_upload_form_btn');
                selector.trigger('click');
            });

            // After selecting media from modal
            $(document).on('media_upload_selected', function(e, data) {
                if(data.trigger_button.hasClass('media_upload_form_btn')) {
                    let wrapper = data.trigger_button.closest('.media-upload-btn-wrapper');
                    
                    if(data.trigger_button.attr('data-mulitple') === 'true') {
                        // For gallery images
                        let galleryInput = wrapper.find('input[name="gallery_images"]');
                        let currentValue = galleryInput.val() ? galleryInput.val().split(',') : [];
                        currentValue.push(data.id);
                        galleryInput.val(currentValue.join(','));
                        
                        // Update preview
                        wrapper.find('.new_image_gallery_add_listing').html(`
                            <div class="attachment-preview">
                                <div class="thumbnail">
                                    <div class="centered">
                                        <img src="${data.url}" alt="${data.name}">
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        // For featured image
                        wrapper.find('input[name="image"]').val(data.id);
                        
                        // Update preview
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
        })(jQuery);
    </script>

    {{-- Store function --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const profileForm = document.getElementById('profileForm');
            const chooseMembershipBtn = document.querySelector('.choose_membership_plan');

            chooseMembershipBtn.addEventListener('click', function() {
                // Validate required fields from the profile form
                const requiredFields = ['name', 'age', 'occupation', 'annual_income', 'caste',
                    'motherTongue', 'country', 'state', 'city', 'description'
                ];

                let missingFields = [];
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input || !input.value.trim()) {
                        missingFields.push(field);
                    }
                });

                // Check if an image is uploaded
                const imageInput = document.getElementById('image_input');
                if (!imageInput || !imageInput.value) {
                    missingFields.push('image');
                }

                if (missingFields.length > 0) {
                    toastr.error('Please fill all required fields including image upload.', 'Validation Error');
                    return false;
                }

                // Populate hidden fields in the modal form
                document.getElementById('modal_name').value = document.getElementById('name').value;
                document.getElementById('modal_age').value = document.getElementById('age').value;
                document.getElementById('modal_occupation').value = document.getElementById('occupation').value;
                document.getElementById('modal_annual_income').value = document.getElementById('annual_income').value;
                document.getElementById('modal_caste').value = document.getElementById('caste').value;
                document.getElementById('modal_motherTongue').value = document.getElementById('motherTongue').value;
                document.getElementById('modal_country').value = document.getElementById('country').value;
                document.getElementById('modal_state').value = document.getElementById('state').value;
                document.getElementById('modal_city').value = document.getElementById('city').value;
                document.getElementById('modal_description').value = document.getElementById('description').value;
                document.getElementById('modal_image').value = document.getElementById('image_input').value;
                document.getElementById('modal_gallery_images').value = document.getElementById('gallery_images_input').value;
            });
        });
    </script>

    {{-- Fetch country --}}
    <script>
        // When the country dropdown changes, get the states
        document.getElementById('country').addEventListener('change', function() {
            const countryId = this.value;
            
            // Reset the state and city dropdowns
            const stateSelect = document.getElementById('state');
            const citySelect = document.getElementById('city');
            stateSelect.innerHTML = '<option value="" selected>Choose State</option>';
            citySelect.innerHTML = '<option value="" selected>Choose City</option>';

            if (countryId) {
                // Fetch states based on selected country
                fetch(`/matrimony/get-states/${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Log the response to verify the data structure
                        if (data.states && data.states.length > 0) {
                            data.states.forEach(state => {
                                const option = document.createElement('option');
                                option.value = state.id;
                                option.textContent = state.state;
                                stateSelect.appendChild(option);
                            });
                        } else {
                            console.log('No states found for this country.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching states:', error);
                    });
            }
        });

        // When the state dropdown changes, get the cities
        document.getElementById('state').addEventListener('change', function() {
            const stateId = this.value;
            
            // Reset the city dropdown
            const citySelect = document.getElementById('city');
            citySelect.innerHTML = '<option value="" selected>Choose City</option>';

            if (stateId) {
                // Fetch cities based on selected state
                fetch(`/matrimony/get-cities/${stateId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Log the response to verify the data structure
                        if (data.cities && data.cities.length > 0) {
                            data.cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.city;
                                citySelect.appendChild(option);
                            });
                        } else {
                            console.log('No cities found for this state.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                    });
            }
        });
    </script>
@endsection