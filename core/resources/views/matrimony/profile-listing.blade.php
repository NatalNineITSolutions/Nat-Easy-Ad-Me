@extends('matrimony.layouts.app') 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('style')
    <style>
        .profile-container {
            background-color: #FFFBEE;
            padding-top: 45px;
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
    </style>
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

                    <form id="profileForm" aria-label="Profile Listing Form">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" id="age" name="age" class="form-control" placeholder="Enter Age" required>
                            </div>
                            <div class="col-md-4">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" id="occupation" name="occupation" class="form-control" placeholder="Enter Occupation" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="income" class="form-label">Annual Income</label>
                                <input type="number" id="income" name="annual_income" class="form-control" placeholder="Enter Annual Income" required>
                            </div>
                            <div class="col-md-4">
                                <label for="caste" class="form-label">Caste</label>
                                <input type="text" id="caste" name="caste" class="form-control" placeholder="Enter Caste" required>
                            </div>
                            <div class="col-md-4">
                                <label for="motherTongue" class="form-label">Mother Tongue</label>
                                <input type="text" id="motherTongue" name="motherTongue" class="form-control" placeholder="Enter Mother Tongue" required>
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" id="country" name="country" class="form-control" required placeholder="Enter Country">
                            </div>
                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" id="state" name="state" class="form-control" required placeholder="Enter State">
                            </div>
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" name="city" class="form-control" required placeholder="Enter City">
                            </div>
                        </div>
                    
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Upload Image</label>
                                <p class="text-muted">Please upload files in jpg, jpeg, or png format and make sure the file size is under 25 MB.</p>
                    
                                <!-- Upload Box -->
                                <div class="upload-box text-center p-4">
                                    <div class="upload-area">
                                        <img src="/assets/uploads/matrimony/upload.png" alt="Upload Icon" class="upload-icon">
                                        <p class="upload-text mb-0">Drop file or Browse</p>
                                        <p class="text-muted mb-0">Format: jpg, jpeg, png & Max file size: 25 MB</p>
                                        <input type="file" class="file-input" name="image" id="image" accept="image/jpg, image/jpeg, image/png" style="opacity: 0; position: absolute; z-index: -1;">
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
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>

@endsection

@section('script')

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

    {{-- Upload Image --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fileInput = document.getElementById("image");
            const browseBtn = document.querySelector(".browse-btn");
            const uploadArea = document.querySelector(".upload-area");
            const uploadedImagesContainer = document.querySelector(".uploaded-images");

            // Browse button click triggers file input
            browseBtn.addEventListener("click", () => {
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener("change", function () {
                const files = fileInput.files;
                if (files.length > 0) {
                    for (let file of files) {
                        if (validateImage(file)) {
                            displayImage(file);
                        }
                    }
                }
            });

            // Drag and Drop Upload
            uploadArea.addEventListener("dragover", function (e) {
                e.preventDefault();
                uploadArea.style.border = "2px solid #6B21A8";
            });

            uploadArea.addEventListener("dragleave", function () {
                uploadArea.style.border = "2px dashed #90119B";
            });

            uploadArea.addEventListener("drop", function (e) {
                e.preventDefault();
                uploadArea.style.border = "2px dashed #90119B";
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    for (let file of files) {
                        if (validateImage(file)) {
                            displayImage(file);
                        }
                    }
                }
            });

            // Validate Image
            function validateImage(file) {
                const allowedExtensions = ["image/jpeg", "image/png", "image/jpg"];
                if (!allowedExtensions.includes(file.type)) {
                    alert("Only JPG, JPEG, and PNG formats are allowed.");
                    return false;
                }
                if (file.size > 25 * 1024 * 1024) {
                    alert("File size should be under 25MB.");
                    return false;
                }
                return true;
            }

            // Display Uploaded Image
            function displayImage(file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = function (e) {
                    const imgContainer = document.createElement("div");
                    imgContainer.classList.add("image-container");

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("uploaded-image");

                    const deleteBtn = document.createElement("button");
                    deleteBtn.innerHTML = "&#10006;";
                    deleteBtn.classList.add("delete-image-btn");
                    deleteBtn.addEventListener("click", function () {
                        imgContainer.remove();
                    });

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(deleteBtn);
                    uploadedImagesContainer.appendChild(imgContainer);
                };
            }
        });
    </script>

    {{-- Store function --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get the form element
            const form = document.getElementById('profileForm');
            if (!form) {
                console.error("Form element with ID 'profileForm' not found!");
                return;
            }
    
            // Add submit event listener
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent default form submission
    
                // Validation logic
                const fields = [
                    { id: 'name', name: "Full Name" },
                    { id: 'age', name: "Age" },
                    { id: 'occupation', name: "Occupation" },
                    { id: 'income', name: "Annual Income" }, // Ensure this matches the form field ID
                    { id: 'caste', name: "Caste" },
                    { id: 'motherTongue', name: "Mother Tongue" },
                    { id: 'country', name: "Country" },
                    { id: 'state', name: "State" },
                    { id: 'city', name: "City" },
                    { id: 'description', name: "Description" }
                ];
    
                let missingFields = [];
                fields.forEach(field => {
                    const input = document.getElementById(field.id);
                    if (!input || !input.value.trim()) {
                        missingFields.push(field.name);
                    }
                });
    
                // Check if an image is uploaded
                const imageInput = document.getElementById('image');
                if (!imageInput || !imageInput.files || imageInput.files.length === 0) {
                    missingFields.push('Image');
                }
    
                if (missingFields.length > 0) {
                    const errorMessage = `${missingFields.join(', ')} is required.`;
                    toastr.error(errorMessage, 'Validation Error');
                    return false; // Stop further execution if validation fails
                }
    
                // AJAX submission logic
                const formData = new FormData(form);
    
                fetch("{{ route('matrimony.profilelisting.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        console.error('Validation Errors:', data.errors);
                    }
                    if (data.success) {
                        toastr.success(data.message);
                        form.reset();
                        document.querySelector(".uploaded-images").innerHTML = "";
                    } else {
                        toastr.error('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred.');
                });
    
                return false; // Prevent default behavior
            });
        });
    </script>
@endsection