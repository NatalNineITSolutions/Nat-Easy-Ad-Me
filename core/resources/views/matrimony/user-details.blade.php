@extends('matrimony.layouts.app')

@section('title', 'Matrimony Login')

@section('style')
    <style>
        .login-container {
            /* background: url('bg-pattern.png') repeat; */
            background-image: url('/assets/uploads/media-uploader/bg.png');
            height: 120vh;
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
@endsection

@section('content')
    <div class="login-container">
        <div class="container d-flex">
            <div class="left"></div>
            <div class="right">
               <div class="user-detail-form">
                    <h3>Matrimony</h3>
                    <p>Join South India's fastest growing matrimonial site</p>

                    <form class="user-form section-1">
                        <div class="row g-3">
                            <!-- Marital Status -->
                            <div class="col-md-6">
                                <label class="form-label">Marital Status</label>
                                <select class="form-select">
                                    <option selected>Choose Status</option>
                                    <option>Unmarried</option>
                                    <option>Divorced</option>
                                    <option>Widowed</option>
                                </select>
                            </div>
                    
                            <!-- DOB -->
                            <div class="col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" class="form-control">
                            </div>
                    
                            <!-- Family Status -->
                            <div class="col-md-6">
                                <label class="form-label">Family Status</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Middle Class
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Rich/Affluent
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Upper Middle Class
                                    </span>
                                </div>
                            </div>
                    
                            <!-- Family Values -->
                            <div class="col-md-6">
                                <label class="form-label">Family Values</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Orthodox
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Traditional
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Moderate
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this)">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Liberal
                                    </span>
                                </div>
                            </div>
                    
                            <!-- Family Type -->
                            <div class="col-md-6">
                                <label class="form-label">Family Type</label>
                                <select class="form-select">
                                    <option selected>Choose Family Type</option>
                                    <option>Joint</option>
                                    <option>Nuclear</option>
                                    <option>Extended</option>
                                </select>
                            </div>
                    
                            <!-- Any Disability -->
                            <div class="col-md-6">
                                <label class="form-label">Any Disability</label>
                                <select class="form-select">
                                    <option selected>No</option>
                                    <option>Yes</option>
                                </select>
                            </div>
                    
                            <!-- Height -->
                            <div class="col-md-6">
                                <label class="form-label">Height</label>
                                <select class="form-select">
                                    <option selected>Feet/Inches</option>
                                    <option>Centimeters</option>
                                </select>
                            </div>
                    
                            <!-- Weight -->
                            <div class="col-md-6">
                                <label class="form-label">Weight</label>
                                <input type="text" class="form-control" placeholder="56kg">
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="next-button" onclick="event.preventDefault(); showSection(2)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-2" style="display: none;">
                        <div class="row g-3">

                            <!--Caste -->
                            <div class="col-md-6">
                                <label class="form-label">Caste</label>
                                <select class="form-select">
                                    <option selected>Choose caste</option>
                                    <option>Mudaliyar</option>
                                    <option>Chettiyar</option>
                                    <option>24manai devanga chettiyar</option>
                                </select>
                            </div>
    
                            <!-- Family Type -->
                            <div class="col-md-6">
                                <label class="form-label">Family Type</label>
                                <select class="form-select">
                                    <option selected>Choose Family Type</option>
                                    <option>Joint</option>
                                    <option>Nuclear</option>
                                    <option>Extended</option>
                                </select>
                            </div>
    
                            <!-- Dosham -->
                            <div class="col-md-6">
                                <label class="form-label">Dosham</label>
                                <select class="form-select">
                                    <option selected>No</option>
                                    <option>Yes</option>
                                </select>
                            </div>

                            <!-- Gothram -->
                            <div class="col-md-6">
                                <label class="form-label">Gothram</label>
                                <select class="form-select">
                                    <option selected>Select one</option>
                                    <option>Viswamithrar</option>
                                    <option>Valmiki Maharshi</option>
                                </select>
                            </div>
    
                            <!-- Next Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="next-button" onclick="event.preventDefault(); showSection(3)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-3" style="display: none;">
                        <div class="row g-3">

                            <!-- Higher education -->
                            <div class="col-md-4">
                                <label class="form-label">Higher Education</label>
                                <select class="form-select">
                                    <option selected>Choose one</option>
                                    <option>BE</option>
                                    <option>MBA</option>
                                    <option>MBBS</option>
                                </select>
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-4">
                                <label class="form-label">Occupation</label>
                                <select class="form-select">
                                    <option selected>Choose one</option>
                                    <option>Biomedical Engineer</option>
                                    <option>Doctor</option>
                                    <option>Developer</option>
                                </select>
                            </div>

                             {{-- Annual Income --}}
                             <div class="col-md-4">
                                <label class="form-label">Annual Income</label>
                                <input type="text" class="form-control" placeholder="Annual income">
                            </div>

                            <!-- Employed In -->
                            <div class="col-md-12">
                                <label class="form-label">Employed In</label>
                                <div class="badge-select">
                                    <span class="badge" onclick="toggleBadge(this, 'Government/PSU')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Government/PSU
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Private')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Private
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Defense')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Defense
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Business')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Business
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Self-employed')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Self-employed
                                    </span>
                                    <span class="badge" onclick="toggleBadge(this, 'Not working')">
                                        <img src="/assets/uploads/media-uploader/delete.png" class="delete" alt="Delete"> 
                                        <img src="/assets/uploads/media-uploader/tick.png" class="tick" alt="Tick"> 
                                        Not working
                                    </span>
                                </div>
                            </div>
                           

                            <!-- Country, State, and City Fields -->
                            <div class="col-md-4 country-state-city" style="display: none;">
                                <label class="form-label">Country</label>
                                <select class="form-select">
                                    <option selected>Select Country</option>
                                    <option>India</option>
                                    <option>Africa</option>
                                    <option>America</option>
                                </select>
                            </div>

                            <div class="col-md-4 country-state-city" style="display: none;">
                                <label class="form-label">State</label>
                                <select class="form-select">
                                    <option selected>Select State</option>
                                    <option>Andhra Pradesh</option>
                                    <option>Tamil Nadu</option>
                                    <option>Karnataka</option>
                                </select>
                            </div>

                            <div class="col-md-4 country-state-city" style="display: none;">
                                <label class="form-label">City</label>
                                <select class="form-select">
                                    <option selected>Select City</option>
                                    <option>Anakapalli</option>
                                    <option>Coimbatore</option>
                                    <option>Bengaluru</option>
                                </select>
                            </div>
                            
                            <!-- Next Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="next-button" onclick="event.preventDefault(); showSection(4)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-4" style="display: none;">
                        <div class="row g-3">

                            <!-- About You Text Area -->
                            <div class="col-md-8">
                                <label class="form-label">About You</label>
                                <textarea class="form-control" rows="4" placeholder="Enter about yourself"></textarea>
                            </div>

                            <!-- Description -->
                            <div class="col-md-4 d-flex align-items-center">
                                <p class="text">Write a few words to get to know you better</p>
                            </div>
                            
                            <!-- Next Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="next-button" onclick="event.preventDefault(); showSection(5)">Next</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-5" style="display: none;">
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
                                        <input type="file" class="file-input" accept="image/jpg, image/jpeg, image/png" hidden multiple>
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
                                <button type="submit" class="next-button" onclick="event.preventDefault(); showSection(6)">Submit</button>
                            </div>
                        </div>
                    </form>

                    <form class="user-form section-6 text-center" style="display: none;">
                        <div class="row g-3 justify-content-center">
                            <!-- Success Image -->
                            <div class="col-12">
                                <img src="/assets/uploads/media-uploader/successfull.png" alt="Success Image" class="success-img">
                            </div>
                    
                            <!-- Success Message -->
                            <div class="col-12">
                                <p class="success-text">Successfully Registered with Easyadmy Matrimony</p>
                                <p class="user-id">Your ID is <strong>A83027374</strong></p>
                            </div>
                    
                            <!-- Button -->
                            <div class="col-12">
                                <button type="button" class="preference-button">Lets Get a Preference</button>
                            </div>
                        </div>
                    </form>
               </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    {{-- Badge toggle --}}
    <script>
        function toggleBadge(element) {
            // Deselect all badges
            document.querySelectorAll(".badge").forEach(badge => {
                if (badge !== element) { // Skip the clicked badge
                    badge.classList.remove("selected");
                }
            });
    
            // Toggle the clicked badge
            if (element.classList.contains("selected")) {
                element.classList.remove("selected");
            } else {
                element.classList.add("selected");
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

    {{-- Country, city and state toggle --}}
    <script>
        // Function to toggle badge selection and show/hide fields
        function toggleBadge(selectedBadge, badgeText) {
            // Remove "selected" from all badges
            document.querySelectorAll(".badge").forEach(badge => {
                badge.classList.remove("selected");
                badge.querySelector(".tick").style.display = "none";
                badge.querySelector(".delete").style.display = "inline";
            });

            // Add "selected" to the clicked badge
            selectedBadge.classList.add("selected");
            selectedBadge.querySelector(".tick").style.display = "inline";
            selectedBadge.querySelector(".delete").style.display = "none";

            // Show/hide Country, State, and City fields based on the selected badge
            const countryStateCityFields = document.querySelectorAll(".country-state-city");
            if (badgeText === "Private") {
                countryStateCityFields.forEach(field => {
                    field.style.display = "block"; // Show fields
                });
            } else {
                countryStateCityFields.forEach(field => {
                    field.style.display = "none"; // Hide fields
                });
            }
        }
    </script>

    {{-- Upload Images --}}
    <script>
        const fileInput = document.querySelector('.file-input');
        const browseBtn = document.querySelector('.browse-btn');
        const cancelBtn = document.querySelector('.cancel-button');
        const uploadedImagesContainer = document.querySelector('.uploaded-images');
    
        // Array to store uploaded images
        let uploadedImages = [];
    
        // Trigger file input when Browse button is clicked
        browseBtn.addEventListener('click', () => {
            fileInput.click(); // Open file dialog
        });
    
        // Handle file selection
        fileInput.addEventListener('change', (event) => {
            const files = event.target.files; // Get selected files
    
            if (files.length > 0) {
                // Check if the total number of uploaded images exceeds 5
                if (uploadedImages.length + files.length > 5) {
                    alert('You can upload a maximum of 5 images.');
                    return;
                }
    
                for (const file of files) {
                    if (file.type.startsWith('image/')) { // Check if the file is an image
                        const reader = new FileReader(); // Read the file
                        reader.onload = (e) => {
                            // Create an image element and set its source
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('uploaded-image');
    
                            // Add a delete button for the image
                            const deleteBtn = document.createElement('button');
                            deleteBtn.textContent = '❌';
                            deleteBtn.type = 'button'; // Ensure it doesn't submit the form
                            deleteBtn.classList.add('delete-image-btn');
                            deleteBtn.addEventListener('click', (event) => {
                                event.preventDefault(); // Prevent form submission
                                event.stopPropagation(); // Stop event bubbling
    
                                // Remove the image container (which includes the image and delete button)
                                imageContainer.remove();
    
                                // Remove the image from the uploadedImages array
                                uploadedImages = uploadedImages.filter((image) => image !== img);
                            });
    
                            // Wrap the image and delete button in a container
                            const imageContainer = document.createElement('div');
                            imageContainer.classList.add('image-container');
                            imageContainer.appendChild(img);
                            imageContainer.appendChild(deleteBtn);
    
                            // Add the image container to the uploadedImagesContainer
                            uploadedImagesContainer.appendChild(imageContainer);
    
                            // Add the image to the uploadedImages array
                            uploadedImages.push(img);
                        };
                        reader.readAsDataURL(file); // Read the file as a data URL
                    } else {
                        alert('Please upload only images (jpg, jpeg, png).');
                    }
                }
            }
        });
    
        // Handle Cancel button click
        cancelBtn.addEventListener('click', () => {
            fileInput.value = ''; // Clear the file input
            uploadedImagesContainer.innerHTML = ''; // Remove all uploaded images
            uploadedImages = []; // Clear the uploadedImages array
        });
    </script>

@endsection