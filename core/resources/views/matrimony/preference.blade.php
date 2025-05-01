<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Matrimony Preference</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .form-select {
            cursor: pointer;
        }

        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .form-control:focus {
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
            background-image: url('/assets/uploads/matrimony/pref-bg.png');
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

        /* Dropdown with checkboxes styling */
        .dropdown-checkbox {
            position: relative;
        }

        .dropdown-checkbox .dropdown-menu {
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-checkbox .dropdown-menu li {
            padding: 5px 0;
        }

        .dropdown-checkbox .form-check-input {
            margin-right: 8px;
        }

        .dropdown-checkbox .form-check-label {
            cursor: pointer;
            width: 100%;
        }

        .selected-options-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
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

</head>

<body>
    <div class="login-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
                <div class="user-detail-form">
                    <h3>Let's get your partner preferences!</h3>

                    <form class="user-form" id="preferenceForm">
                        <div class="row g-3">
                            <!-- Partner's Age -->
                            <div class="col-md-6">
                                <label class="form-label">Partner's Age</label>
                                <select class="form-select" name="partner_age" id="partner_age">
                                    <option value="" selected>Choose Partner's Age</option>
                                    @foreach($ages as $age)
                                        <option value="{{ $age->id }}">{{ $age->from_age }} - {{ $age->to_age }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Mother Tongue -->
                            <div class="col-md-6">
                                <label class="form-label">Mother Tongue</label>
                                <select class="form-select" name="mother_tongue" id="mother_tongue">
                                    <option value="" selected>Choose Mother Tongue</option>
                                    @foreach($motherTongues as $tongue)
                                        <option value="{{ $tongue->id }}">{{ $tongue->mother_tongue }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" id="location"
                                    placeholder="Enter the Location">
                            </div>

                            <!-- Zodiac Sign -->
                            <div class="col-md-6">
                                <label class="form-label">Zodiac Sign</label>
                                <select id="zodiac_sign" name="zodiac_sign[]" multiple>
                                    @foreach($zodiacsigns as $zodiacsign)
                                        <option value="{{ $zodiacsign->id }}" @if(is_array($selectedZodiac) && in_array($zodiacsign->id, $selectedZodiac)) selected @endif>
                                            {{ $zodiacsign->zodiac_sign }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Star -->
                            <div class="col-md-6">
                                <label class="form-label">Star</label>
                                <select id="star" name="star[]" multiple>
                                    @foreach($stars as $star)
                                        <option value="{{ $star->id }}" @if(is_array($selectedStars) && in_array($star->id, $selectedStars)) selected @endif>
                                            {{ $star->star }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Religion -->
                            <div class="col-md-6">
                                <label class="form-label">Religion</label>
                                <select class="form-select" name="religion" id="religion">
                                    <option value="" selected>Choose Religion</option>
                                    @foreach($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->religion }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Caste -->
                            <div class="col-md-6">
                                <label class="form-label">Caste</label>
                                <select class="form-select" name="caste" id="caste">
                                    <option value="" selected>Choose Caste</option>
                                    @foreach($castes as $caste)
                                        <option value="{{ $caste->id }}">{{ $caste->caste }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Height -->
                            <div class="col-md-6">
                                <label class="form-label">Height</label>
                                <input type="text" class="form-control" name="height" id="height" placeholder="152cm">
                            </div>

                            <!-- Weight -->
                            <div class="col-md-6">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" placeholder="56kg">
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-6">
                                <label class="form-label">Occupation</label>
                                <input type="text" class="form-control" name="occupation" id="occupation"
                                    placeholder="Enter the Occupation">
                            </div>

                            <!-- Marital Status -->
                            <div class="col-md-6">
                                <label for="marital_status" class="form-label">Marital Status</label>
                                <select class="form-select" id="marital_status" name="marital_status" required>
                                    <option value="" selected disabled>Choose Marital Status</option>
                                    @foreach($marital_status as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Monthly Income -->
                            <div class="col-md-12">
                                <label class="form-label">Monthly Income</label>
                                <select class="form-select" name="income" id="income">
                                    <option value="" selected>Choose Monthly Income</option>
                                    @foreach($income as $inc)
                                        <option value="{{ $inc->id }}">{{ $inc->from_income }} - {{ $inc->to_income }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="next-button">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Toaster initialization --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };
    </script>

    {{-- Form Submission AJAX --}}
    <script>
        document.getElementById('preferenceForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Get all selected values
            const formData = new FormData(this);
            const jsonData = {};

            // Convert FormData to object, handling arrays
            for (let [key, value] of formData.entries()) {
                if (key.endsWith('[]')) {
                    const fieldName = key.replace('[]', '');
                    if (!jsonData[fieldName]) {
                        jsonData[fieldName] = [];
                    }
                    jsonData[fieldName].push(value);
                } else {
                    // Special handling for select dropdowns with display text (like ranges)
                    if (key === 'partner_age' || key === 'income') {
                        const selectElement = document.getElementById(key);
                        jsonData[key] = selectElement.options[selectElement.selectedIndex].text;
                    } else {
                        jsonData[key] = value;
                    }
                }
            }

            // Add CSRF token
            jsonData['_token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Validation
            const requiredFields = [
                { id: 'partner_age', name: "Partner's Age" },
                { id: 'income', name: "Monthly Income" },
                { id: 'mother_tongue', name: "Mother Tongue" },
                { id: 'religion', name: "Religion" },
                { id: 'caste', name: "Caste" },
                { id: 'zodiac_sign', name: "Zodiac Sign" },
                { id: 'star', name: "Star" },
                { id: 'height', name: "Height" },
                { id: 'weight', name: "Weight" },
                { id: 'occupation', name: "Occupation" },
                { id: 'location', name: "Location" },
                { id: 'income', name: "Monthly Income" }
            ];

            let missingFields = [];
            requiredFields.forEach(field => {
                if (!jsonData[field.id]) {
                    missingFields.push(field.name);
                }
            });

            if (missingFields.length > 0) {
                toastr.error(`${missingFields.join(', ')} ${missingFields.length > 1 ? 'are' : 'is'} required.`, 'Validation Error');
                return;
            }

            // AJAX request
            fetch('/matrimony/preference', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': jsonData['_token']
                },
                body: JSON.stringify(jsonData)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 2000);
                    } else {
                        toastr.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error(error.message || 'An unexpected error occurred.');
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#zodiac_sign', {
                removeItemButton: true,
                placeholderValue: 'Select Zodiac Signs',
                searchPlaceholderValue: 'Search Zodiac...'
            });

            new Choices('#star', {
                removeItemButton: true,
                placeholderValue: 'Select Stars',
                searchPlaceholderValue: 'Search Star...'
            });
        });
    </script>

</body>

</html>