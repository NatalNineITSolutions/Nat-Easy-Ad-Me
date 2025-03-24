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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

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

        .delete, .tick {
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .badge .delete {
            display: inline; /* Show delete icon by default */
        }

        .badge .tick {
            display: none; /* Hide tick icon by default */
        }

        .badge.selected .delete {
            display: none; /* Hide delete icon when selected */
        }

        .badge.selected .tick {
            display: inline; /* Show tick icon when selected */
        }

        .next-button {
            background-color: #FF0066; /* Pink */
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
            background-color: #E6005C; /* Slightly darker pink */
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
                                    <option value="Divorce">Divorce</option>
                                </select>
                            </div>
                    
                            <!-- DOB -->
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" class="form-control" name="dob" id="dob">
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
                                    <span class="badge" onclick="toggleBadge(this, 'Upper Middle Class', 'family_status')">
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
                                <input type="number" class="form-control" name="height" id="height" step="0.1" min="50" max="250">
                            </div>
                    
                            <!-- Weight -->
                            <div class="col-md-6">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" name="weight" id="weight" placeholder="56kg">
                            </div>
                    
                            <div class="col-12 text-end">
                                <button type="submit" class="next-button" onclick="validateSection(event, 1)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-2" style="display: none;">
                        <div class="row g-3">
                            <!-- Caste -->
                            <div class="col-md-12">
                                <label class="form-label">Caste</label>
                                <select class="form-select" name="caste" id="caste">
                                    <option value="" selected>Choose caste</option> <!-- Empty value -->
                                    @foreach($castes as $caste)
                                        <option value="{{ $caste->id }}">{{ $caste->caste }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                           <!-- Gothram Dropdown -->
                            <div class="col-md-12">
                                <label class="form-label">Gothram</label>
                                <select class="form-select" name="gothram" id="gothram">
                                    <option value="" selected>Choose gothram</option>
                                    @foreach($gothrams as $gothram)
                                        <option value="{{ $gothram->id }}">{{ $gothram->gothram }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Dosham Dropdown -->
                            <div class="col-md-12">
                                <label class="form-label">Dosham</label>
                                <select class="form-select" name="dosham" id="dosham">
                                    <option value="" selected>Choose dosham</option>
                                    @foreach($doshams as $dosham)
                                        <option value="{{ $dosham->id }}">{{ $dosham->dosham }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Next Button -->
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
                                    <option value="BE">BE</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MBBS">MBBS</option>
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
                                <input type="text" class="form-control" name="annual_income" id="annual_income" placeholder="Annual income">
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
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-4">
                                <x-form.country-dropdown :title="__('Select Your Country')" :id="'country_id'" :required="true"/>
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
                                <button type="submit" class="next-button" onclick="validateSection(event, 3)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-4" style="display: none;" id="user-form">
                        <div class="row g-3">
                            <!-- About You Text Area -->
                            <div class="col-md-8">
                                <label class="form-label">About You</label>
                                <textarea class="form-control" name="about" id="about_you" rows="4" placeholder="Enter about yourself"></textarea>
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

                    {{-- <form class="user-form section-5" style="display: none;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Upload Image</label>
                                <p class="text-muted">Please upload files in jpg, jpeg, or png format and make sure the file size is under 25 MB.</p>
                    
                                <!-- Upload Box -->
                                <div class="upload-box text-center p-4">
                                    <div class="upload-area">
                                        <img src="/assets/uploads/media-uploader/upload.png" alt="Upload Icon" class="upload-icon">
                                        <p class="upload-text mb-0">Drop file or Browse</p>
                                        <p class="text-muted mb-0">Format: jpg, jpeg, png & Max file size: 25 MB</p>
                                        <input type="file" class="file-input" name="image" id="image" accept="image/jpg, image/jpeg, image/png" hidden multiple>
                                    </div>
                    
                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="button" class="upload-btn browse-btn">Browse</button>
                                        <button type="button" class="upload-btn cancel-button">Cancel</button>
                                    </div>
                                </div>
                    
                                <!-- Preview Uploaded Images -->
                                <div class="uploaded-images mt-3"></div>
                            </div>
                    
                            <!-- Next Button -->
                            <div class="col-12 text-end">
                                <button type="submit" id="submit-btn" class="next-button" onclick="validateSection(event, 5)">Submit</button>
                            </div>
                        </div>
                    </form> --}}

                    <form class="user-form section-6 text-center" style="display: none;">
                        <div class="row g-3 justify-content-center">
                            <!-- Success Image -->
                            <div class="col-12">
                                <img src="/assets/uploads/matrimony/successfull.png" alt="Success Image" class="success-img">
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

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Country, state, city --}}
    <script>
        $('#country').on('change', function () {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: '{{ route("matrimony.get-states", ":id") }}'.replace(':id', country_id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#state').empty().append('<option value="">Choose state</option>');
                        $.each(data, function (key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.state + '</option>');
                        });
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
                    url: '{{ route("matrimony.get-cities", ":id") }}'.replace(':id', state_id),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#city').empty().append('<option value="">Choose city</option>');
                        $.each(data, function (key, value) {
                            $('#city').append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
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

    {{-- Form Validation --}}
    <script>
        function validateSection(event, sectionNumber) {
            event.preventDefault(); // Prevent form submission

            const sectionFields = {
                1: [
                    { id: 'marital_status', name: 'Marital Status' },
                    { id: 'dob', name: 'Date of Birth' },
                    { id: 'family_status', name: 'Family Status' },
                    { id: 'family_values', name: 'Family Values' },
                    { id: 'family_type', name: 'Family Type' },
                    { id: 'disability', name: 'Disability' },
                    { id: 'height', name: 'Height' },
                    { id: 'weight', name: 'Weight' }
                ],
                2: [
                    { id: 'caste', name: 'Caste' },
                    { id: 'dosham', name: 'Dosham' },
                    { id: 'gothram', name: 'Gothram' }
                ],
                3: [
                    { id: 'education', name: 'Higher Education' },
                    { id: 'occupation', name: 'Occupation' },
                    { id: 'annual_income', name: 'Annual Income' },
                    { id: 'employed_in', name: 'Employed In' },
                    { id: 'country', name: 'Country' },
                    { id: 'state', name: 'State' },
                    { id: 'city', name: 'City' }
                ],
                4: [
                    { id: 'about_you', name: 'About You' }
                ],
                5: [] // Removed 'image' field
            };

            const requiredFields = sectionFields[sectionNumber];
            let isValid = true;
            let missingFields = [];
            let validationMessage = '';

            requiredFields.forEach(field => {
                const value = document.getElementById(field.id).value;
                if (!value) {
                    isValid = false;
                    missingFields.push(field.name);
                }
            });

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
            const formData = new FormData();

            function getValue(selector) {
                const element = document.querySelector(selector);
                return element ? element.value : ''; // Return empty string if not found
            }

            formData.append('marital_status', document.querySelector('[name="marital_status"]').value);
            formData.append('dob', document.querySelector('[name="dob"]').value);
            formData.append('family_status', document.getElementById('family_status').value);
            formData.append('family_values', document.getElementById('family_values').value);
            formData.append('family_type', document.querySelector('[name="family_type"]').value);
            formData.append('disability', document.querySelector('[name="disability"]').value);
            formData.append('height', document.querySelector('[name="height"]').value);
            formData.append('weight', document.querySelector('[name="weight"]').value);
            formData.append('caste', document.querySelector('[name="caste"]').value);
            formData.append('dosham', document.querySelector('[name="dosham"]').value);
            formData.append('gothram', document.querySelector('[name="gothram"]').value);
            formData.append('education', document.querySelector('[name="education"]').value);
            formData.append('occupation', document.querySelector('[name="occupation"]').value);
            formData.append('annual_income', document.querySelector('[name="annual_income"]').value);
            formData.append('employed_in', document.getElementById('employed_in').value);
            formData.append('country', document.querySelector('[name="country"]').value);
            formData.append('state', document.querySelector('[name="state"]').value);
            formData.append('city', document.querySelector('[name="city"]').value);
            formData.append('about', document.querySelector('[name="about"]').value);
            // Removed 'image' field

            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            fetch('/matrimony/user-details', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success('KYC submitted successfully! Please fill preferences to complete your profile.');

                    showSection(6); 
                    
                    // Update UI to reflect user ID if needed
                    document.querySelector('.user-id strong').textContent = data.user_id;
                } else {
                    toastr.error('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error(error.message || 'An unexpected error occurred.');
            });
        }
    </script>

    {{-- Form submission --}}
    <script>
        document.getElementById('submit-btn').addEventListener('click', function(event) {
            event.preventDefault();
            validateSection(event, 4); 
        });
    </script>
</body>
</html>