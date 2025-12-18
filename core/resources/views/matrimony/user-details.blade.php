<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Matrimony - User Details</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .form-select {
            cursor: pointer;
        }

        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .login-container {
            /* background: url('bg-pattern.png') repeat; */
            background-image: url('/assets/uploads/media-uploader/bg.png');
            height: 100vh;
            padding: 50px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left {
            width: 50%;
            display: block;
            background-image: url('/assets/uploads/media-uploader/reg-bg.jpeg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding: 50px 0;
            height: auto;
        }

        .right {
            width: 50%;
            background: white;
            padding: 20px 0;
            display: flex;
            align-content: center;
            justify-content: center;
        }

        .user-detail-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px 40px;
        }

        .user-detail-form h3 {
            color: #b39055;
            font-size: 16px;
            font-weight: 600;
        }

        .user-detail-form p {
            font-size: 14px;

            font-weight: 500;
        }

        .user-form {
            margin-top: 20px;
        }

        .user-form label {
            font-size: 12px;
            font-weight: 600;
        }

        .user-form select {
            font-size: 12px;
            font-weight: 500;
        }

        .user-form input {
            font-size: 12px;
            font-weight: 500;
        }

        .badge-select {
            display: flex;
            flex-wrap: wrap;
        }

        .badge {
            background-color: #F4F9FD;
            color: #0A1629;
            cursor: pointer;
            padding: 5px 8px;
            font-size: 9px;
            font-weight: 600;
            margin: 3px;
            border-radius: 5px;
            display: inline-block;
        }

        .badge.selected {
            background-color: #e6ffe6;
        }

        .delete,
        .tick {
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .badge .delete {
            display: inline;
            /* Show delete icon by default */
        }

        .badge .tick {
            display: none;
            /* Hide tick icon by default */
        }

        .badge.selected .delete {
            display: none;
            /* Hide delete icon when selected */
        }

        .badge.selected .tick {
            display: inline;
            /* Show tick icon when selected */
        }

        .next-button {
            background-color: #FF0066;
            /* Pink */
            color: white;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 13px;
        }

        .next-button:hover {
            background-color: #E6005C;
            /* Slightly darker pink */
        }

        .text {
            font-size: 14px;
            font-weight: 600;
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

        .success-img {
            width: 60%;
        }

        .preference-button {
            background-color: #FF0066;
            color: white;
            font-size: 16px;
            font-weight: 12px;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            width: 100%;
            max-width: 300px;
        }

        /* Image Upload */
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

        @media (max-width: 991px) {

            .left {
                display: none;
            }

            .right {
                padding: 20px;
                width: 100%;
            }
        }

        @media (max-width: 768px) {

            .left {
                display: none;
            }

            .login-container {
                height: auto;
            }

            .user-detail-form {
                padding: 15px 25px;
            }

            .right {
                width: 100%;
            }
        }
    </style>
    <x-media.css />
</head>

<body>
    <div class="login-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
                <div class="user-detail-form">
                    <h3>Join South India's fastest growing matrimonial site</h3>

                    <form class="user-form section-1">
                        <div class="row g-3">
                            <!-- Marital Status -->
                            <div class="col-md-6">
                                <label class="form-label">Marital Status</label>
                                <select class="form-select" name="marital_status" id="marital_status">
                                    <option value="" selected>Choose Status</option>
                                    <option value="Unmarried">Unmarried</option>
                                    <option value="Married">Married</option>
                                    <option value="Second Marriage">Second Marriage</option>
                                </select>
                            </div>

                            <!-- DOB -->
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" class="form-control" name="dob" id="dob">
                            </div>

                            <div class="col-md-12" id="divorce_doc_div" style="display: none;">
                                <label class="form-label">Upload Divorce Order</label>
                                <input type="file" class="form-control" name="document" id="document"
                                    accept=".pdf,application/pdf">
                            </div>

                            <!-- Family Status -->
                            <div class="col-md-6">
                                <label class="form-label">Family Status</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this, 'Middle Class', 'family_status')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Middle Class
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Rich/Affluent', 'family_status')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Rich/Affluent
                                    </span>
                                    <span class="badge"
                                        onclick="toggleBadge(this, 'Upper Middle Class', 'family_status')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Upper Middle Class
                                    </span>
                                </div>
                                <input type="hidden" name="family_status" id="family_status">
                            </div>

                            <!-- Family Values -->
                            <div class="col-md-6">
                                <label class="form-label">Family Values</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this, 'Orthodox', 'family_values')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Orthodox
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Traditional', 'family_values')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Traditional
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Moderate', 'family_values')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Moderate
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Liberal', 'family_values')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Liberal
                                    </span>
                                </div>
                                <input type="hidden" name="family_values" id="family_values">
                            </div>

                            <!-- Family Type -->
                            <div class="col-md-6">
                                <label class="form-label">Family Type</label>
                                <select class="form-select" name="family_type" id="family_type">
                                    <option value="" selected>Choose Family Type</option> <!-- Empty value -->
                                    <option value="Joint">Joint</option>
                                    <option value="Nuclear">Nuclear</option>
                                    <option value="Extended">Extended</option>
                                </select>
                            </div>

                            <!-- Any Disability -->
                            <div class="col-md-6">
                                <label class="form-label">Any Disability</label>
                                <select class="form-select" name="disability" id="disability">
                                    <option value="" selected>Choose Disability</option> <!-- Empty value -->
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>

                            <!-- Height -->
                            <div class="col-md-6">
                                <label class="form-label">Height (in cm)</label>
                                <input type="number" class="form-control" name="height" id="height" step="0.1" min="50"
                                    max="250">
                            </div>

                            <!-- Weight -->
                            <div class="col-md-6">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" placeholder="56kg">
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="next-button"
                                    onclick="validateSection(event, 1)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-2" style="display: none;">
    <div class="row g-3">

        <div class="col-md-12">
            <label class="form-label">Zodiac Sign</label>
            <select class="form-select searchable-select" name="zodiac_sign" id="zodiac_sign">
                <option value="" selected>Choose zodiac sign</option>
                @foreach($zodiacsigns as $zodiac)
                    <option value="{{ $zodiac->id }}">{{ $zodiac->zodiac_sign }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Star</label>
            <select class="form-select searchable-select" name="star" id="star">
                <option value="" selected>Choose star</option>
                @foreach($stars as $star)
                    <option value="{{ $star->id }}">{{ $star->star }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Caste</label>
            <select class="form-select searchable-select" name="caste" id="caste">
                <option value="" selected>Choose caste</option>
                @foreach ($castes as $caste)
                    <option value="{{ $caste->id }}">{{ $caste->caste }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Gothram</label>
            <select class="form-select searchable-select" name="gothram" id="gothram">
                <option value="" selected>Choose gothram</option>
                @foreach ($gothrams as $gothram)
                    <option value="{{ $gothram->id }}">{{ $gothram->gothram }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">Dosham</label>
            <select class="form-select searchable-select" name="dosham" id="dosham">
                <option value="" selected>Choose dosham</option>
                @foreach ($doshams as $dosham)
                    <option value="{{ $dosham->id }}">{{ $dosham->dosham }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="next-button" onclick="validateSection(event, 2)">Next</button>
        </div>
    </div>
</form>


                    <form class="user-form section-3" style="display: none;">
                        <div class="row g-3">
                            <!-- Higher Education -->
                            <div class="col-md-4">
                                <label class="form-label">Higher Education</label>
                                <select class="form-select" name="education" id="education">
                                    <option value="" selected>Choose one</option>
                                </select>
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <select class="form-select" name="occupation" id="occupation">
                                    <option value="" selected>Choose one</option>
                                    <option value="Biomedical Engineer">Biomedical Engineer</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Developer">Developer</option>
                                </select>
                            </div>

                            <!-- Annual Income -->
                            <div class="col-md-4">
                                <label class="form-label">Annual Income</label>
                                <input type="text" class="form-control" name="annual_income" id="annual_income"
                                    placeholder="Annual income">
                            </div>

                            <!-- Employed In -->
                            <div class="col-md-12">
                                <label class="form-label">Employed In</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this, 'Government', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Government
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Private', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Private
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Defense', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Defense
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Business', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Business
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Self-employed', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Self-employed
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Not working', 'employed_in')">
                                        <img src="/assets/uploads/matrimony/delete.png" class="delete" alt="Delete">
                                        <img src="/assets/uploads/matrimony/tick.png" class="tick" alt="Tick">
                                        Not working
                                    </span>
                                </div>
                                <input type="hidden" name="employed_in" id="employed_in">
                            </div>

                            <!-- Country, State, and City Fields -->
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <select class="form-select" name="country" id="country">
                                    <option value="" selected>Choose country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-4">
                                <x-form.country-dropdown :title="__('Select Your Country')" :id="'country_id'"
                                    :required="true" />
                            </div> --}}

                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <select class="form-select" name="state" id="state">
                                    <option value="" selected>Choose state</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <select class="form-select" name="city" id="city">
                                    <option value="" selected>Choose city</option>
                                </select>
                            </div>

                            <!-- Next Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="next-button"
                                    onclick="validateSection(event, 3)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-4" style="display: none;" id="user-form">
                        <div class="row g-3">

                            {{-- User images --}}
                            <div class="col-12">
                                <label class="form-label">Profile Picture <span class="text-danger">*</span></label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap new_image_add_listing">
                                        <img src="{{ asset('assets/common/img/listing_single_image.jpg') }}"
                                            alt="images" class="w-100">
                                    </div>
                                    <input type="hidden" name="image" id="images_input">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                        data-btntitle="{{ __('Select Image') }}"
                                        data-modaltitle="{{ __('Upload Image') }}" data-bs-toggle="modal"
                                        data-bs-target="#media_upload_modal" data-mulitple="true">
                                        {{ __('Upload Profile Picture') }}
                                    </button>
                                    <small>{{ __('image format: jpg, jpeg, png, gif, webp') }}</small>
                                </div>
                                <div class="uploaded-images mt-3" id="uploaded-images-container">
                                    <!-- Preview of uploaded images will appear here -->
                                </div>
                            </div>

                            <!-- About You Text Area -->
                            <div class="col-md-8">
                                <label class="form-label">About You</label>
                                <textarea class="form-control" name="about" id="about_you" rows="4"
                                    placeholder="Enter about yourself"></textarea>
                            </div>

                            <!-- Description -->
                            <div class="col-md-4 d-flex align-items-center">
                                <p class="text">Write a few words to get to know you better</p>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end">
                                <button type="submit" id="submit-btn" class="next-button">Submit</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-6 text-center" style="display: none;">
                        <div class="row g-3 justify-content-center">
                            <!-- Success Image -->
                            <div class="col-12">
                                <img src="/assets/uploads/matrimony/successfull.png" alt="Success Image"
                                    class="success-img">
                            </div>

                            <!-- Success Message -->
                            <div class="col-12">
                                <p class="success-text">Successfully Registered with Easyadmy Matrimony</p>
                                <p class="user-id">Your ID is <strong>A83027374</strong></p>
                            </div>

                            <!-- Button -->
                            <div class="col-12">
                                <a href="/matrimony/preference" class="btn-link">
                                    <button type="button" class="preference-button">Let's Get a Preference</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-media.markup type="web" />


    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Show Divorce upload Input --}}
    <script>
        document.getElementById('marital_status').addEventListener('change', function () {
            var divorceDiv = document.getElementById('divorce_doc_div');
            if (this.value === 'Second Marriage') {
                divorceDiv.style.display = 'block';
            } else {
                divorceDiv.style.display = 'none';
            }
        });
    </script>

    {{-- Country, state, city --}}
    <script>
        $('#country').on('change', function () {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: '{{ route('matrimony.get-states', ':id') }}'.replace(':id', country_id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#state').empty().append('<option value="">Choose state</option>');
                        $.each(data.states, function (key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value
                                .state + '</option>');
                        });
                    },
                    error: function () {
                        alert("Error fetching states. Please try again.");
                    }
                });
            } else {
                $('#state').empty().append('<option value="">Choose state</option>');
            }
        });

        $('#state').on('change', function () {
            var state_id = $(this).val();
            if (state_id) {
                $.ajax({
                    url: '{{ route('matrimony.get-cities', ':id') }}'.replace(':id', state_id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#city').empty().append('<option value="">Choose city</option>');
                        $.each(data.cities, function (key, value) {
                            $('#city').append('<option value="' + value.id + '">' + value.city +
                                '</option>');
                        });
                    },
                    error: function () {
                        alert("Error fetching cities. Please try again.");
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Choose city</option>');
            }
        });
    </script>

    {{-- Toaster initialization --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };
    </script>

    {{-- Badge toggle --}}
    <script>
        function toggleBadge(element, value, inputId) {
            // Deselect all badges within the same container
            const badgeContainer = element.closest('.badge-select');
            badgeContainer.querySelectorAll('.badge').forEach(badge => {
                badge.classList.remove('selected');
            });

            // Toggle the clicked badge
            element.classList.toggle('selected');

            // Update the hidden input field with the selected value
            const hiddenInput = document.getElementById(inputId);
            if (element.classList.contains('selected')) {
                hiddenInput.value = value;
            } else {
                hiddenInput.value = ''; // Clear if deselected
            }
        }
    </script>

    {{-- Delete and tick toggle --}}
    <script>
        // Function to switch between form sections
        function showSection(sectionNumber) {
            // Hide all sections
            document.querySelectorAll('.user-form').forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected section
            const sectionToShow = document.querySelector(`.section-${sectionNumber}`);
            if (sectionToShow) {
                sectionToShow.style.display = 'block';
            }
        }
    </script>

    {{-- Image --}}
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
        });
    </script>

    {{-- Form Validation --}}
    <script>
        function validateSection(event, sectionNumber) {
            event.preventDefault(); // Prevent form submission

            const sectionFields = {
                1: [{
                    id: 'marital_status',
                    name: 'Marital Status'
                },
                {
                    id: 'dob',
                    name: 'Date of Birth'
                },
                {
                    id: 'family_status',
                    name: 'Family Status'
                },
                {
                    id: 'family_values',
                    name: 'Family Values'
                },
                {
                    id: 'family_type',
                    name: 'Family Type'
                },
                {
                    id: 'disability',
                    name: 'Disability'
                },
                {
                    id: 'height',
                    name: 'Height'
                },
                {
                    id: 'weight',
                    name: 'Weight'
                }
                ],
                2: [
                // Caste, Gothram, Dosham, Zodiac Sign and Star are now OPTIONAL client-side
                ],
                3: [{
                    id: 'education',
                    name: 'Higher Education'
                },
                {
                    id: 'occupation',
                    name: 'Occupation'
                },
                {
                    id: 'annual_income',
                    name: 'Annual Income'
                },
                {
                    id: 'employed_in',
                    name: 'Employed In'
                },
                {
                    id: 'country',
                    name: 'Country'
                },
                {
                    id: 'state',
                    name: 'State'
                },
                {
                    id: 'city',
                    name: 'City'
                }
                ],
                4: [{
                    id: 'about_you',
                    name: 'About You'
                }],
                5: []
            };

            const requiredFields = sectionFields[sectionNumber];
            let isValid = true;
            let missingFields = [];
            let validationMessage = '';

            requiredFields.forEach(field => {
                const el = document.getElementById(field.id);
                const value = el ? el.value : '';
                if (!value) {
                    isValid = false;
                    missingFields.push(field.name);
                }
            });

            // Divorce Order validation
            const maritalStatus = document.getElementById('marital_status')?.value;
            const divorceDoc = document.getElementById('document');
            if (maritalStatus === 'Second Marriage' && (!divorceDoc || !divorceDoc.files.length)) {
                isValid = false;
                missingFields.push('Divorce Order Document');
            }

            if (!isValid) {
                toastr.error(`Please fill out the following fields: ${missingFields.join(', ')}`);
            } else {
                if (sectionNumber === 4) { // If section 4 is validated, submit the form
                    submitForm();
                } else {
                    showSection(sectionNumber + 1);
                }
            }
        }

        function submitForm() {
            // Create FormData object
            const formData = new FormData();

            // Helper function to safely get values
            function getValue(selector) {
                const el = document.querySelector(selector);
                return el ? el.value : null;
            }

            // Section 1: Personal Details
            formData.append('marital_status', getValue('.section-1 [name="marital_status"]'));
            formData.append('dob', getValue('.section-1 [name="dob"]'));
            formData.append('family_status', getValue('.section-1 #family_status'));
            formData.append('family_values', getValue('.section-1 #family_values'));
            formData.append('family_type', getValue('.section-1 [name="family_type"]'));
            formData.append('disability', getValue('.section-1 [name="disability"]'));
            formData.append('height', getValue('.section-1 [name="height"]'));
            formData.append('weight', getValue('.section-1 [name="weight"]'));

            // Section 2: Horoscope Details (all optional client-side)
            formData.append('caste', getValue('.section-2 [name="caste"]'));
            formData.append('dosham', getValue('.section-2 [name="dosham"]'));
            formData.append('gothram', getValue('.section-2 [name="gothram"]'));
            formData.append('zodiac_sign', getValue('.section-2 [name="zodiac_sign"]'));
            formData.append('star', getValue('.section-2 [name="star"]'));

            // Section 3: Professional Details
            formData.append('education', getValue('.section-3 [name="education"]'));
            formData.append('occupation', getValue('.section-3 [name="occupation"]'));
            formData.append('annual_income', getValue('.section-3 [name="annual_income"]'));
            formData.append('employed_in', getValue('.section-3 #employed_in'));
            formData.append('country', getValue('.section-3 [name="country"]'));
            formData.append('state', getValue('.section-3 [name="state"]'));
            formData.append('city', getValue('.section-3 [name="city"]'));

            // Section 4: Profile Details
            formData.append('about', getValue('.section-4 [name="about"]'));
            formData.append('image', getValue('.section-4 [name="image"]'));

            // Handle divorce document if applicable
            const maritalStatus = getValue('.section-1 [name="marital_status"]');
            const divorceDoc = document.querySelector('.section-1 [name="document"]');
            if (maritalStatus === 'Second Marriage' && divorceDoc && divorceDoc.files[0]) {
                formData.append('document', divorceDoc.files[0]);
            }

            // Debug: Log all form data before sending
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Send the request
            fetch('/matrimony/user-details', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        showSection(6);
                        document.querySelector('.user-id strong').textContent = data.user_id;
                        toastr.success('Profile submitted successfully!');
                    } else {
                        toastr.error(data.message || 'Submission failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('Failed to submit: ' + error.message);
                });
        }
    </script>

    {{-- Form submission --}}
    <script>
        document.getElementById('submit-btn').addEventListener('click', function (event) {
            event.preventDefault();
            validateSection(event, 4);
        });
    </script>
  <script>
document.addEventListener('DOMContentLoaded', async function () {
  // helper to fetch and parse json, returns array or null
  async function fetchList(url) {
    try {
      const res = await fetch(url, { cache: 'no-store' });
      console.log('[LIST DEBUG] fetched', url, res.status);
      if (!res.ok) { console.warn('[LIST DEBUG] non-OK', url, res.status); return null; }
      const text = await res.text();
      try {
        const parsed = JSON.parse(text);
        if (!Array.isArray(parsed)) { console.warn('[LIST DEBUG] not array', url); return null; }
        return parsed;
      } catch (pe) {
        console.error('[LIST DEBUG] JSON parse error for', url, pe);
        return null;
      }
    } catch (err) {
      console.error('[LIST DEBUG] fetch error for', url, err);
      return null;
    }
  }

  // populate a select element with given list (array of strings)
  function populateSelect(selectId, list, fallback) {
    const sel = document.getElementById(selectId);
    if (!sel) return;
    const currentVal = sel.value || '';
    const source = (Array.isArray(list) && list.length) ? list : fallback;
    if (!Array.isArray(list) || !list.length) console.warn(`[LIST DEBUG] using fallback for ${selectId}`);
    let html = '<option value="">Choose one</option>';
    source.forEach(item => {
      const val = item == null ? '' : String(item);
      const esc = val.replace(/"/g, '&quot;');
      const selAttr = (currentVal && currentVal === val) ? ' selected' : '';
      html += `<option value="${esc}"${selAttr}>${esc}</option>`;
    });
    sel.innerHTML = html;
    // If select2 in use, notify
    if (window.jQuery && $(sel).hasClass('select2')) {
      try { $(sel).trigger('change.select2'); } catch(e){ console.warn('select2 refresh failed', e); }
    }
  }

  // fallback lists (short safe defaults)
  const eduFallback = [
    "High School","Intermediate / 12th","Diploma","Bachelor's Degree (BA / BSc / BCom)",
    "B.Tech / BE","MBA / PGDM","MBBS / BDS","Master's Degree (MA / MSc / MCom)","Other"
  ];
  const occFallback = [
    "Developer / Programmer","Doctor","Teacher","Engineer","Business Owner","Unemployed","Other"
  ];

  // fetch both lists in parallel
  const [eduList, occList] = await Promise.all([
    fetchList('/data/educations.json'),
    fetchList('/data/occupations.json')
  ]);

  // populate selects (only if elements exist on page)
  populateSelect('education', eduList, eduFallback);
  populateSelect('occupation', occList, occFallback);

  console.log('[LIST DEBUG] done populating education & occupation');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.searchable-select').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });
});
</script>


</body>

</html>
