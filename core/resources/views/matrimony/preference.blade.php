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

                    <form class="user-form" id="preferenceForm">
                        <div class="row g-3">
                            <!-- Partner's Age -->
                            <div class="col-md-6">
                                <label class="form-label">Partner's Age</label>
                                <input type="number" class="form-control" name="partner_age" id="partner_age" placeholder="Enter Partner's Age" min="18" max="100">
                            </div>
                
                            <!-- Mother Tongue -->
                            <div class="col-md-6">
                                <label class="form-label">Mother Tongue</label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" placeholder="Enter Mother Tongue">
                            </div>
                
                            <!-- Religion -->
                            <div class="col-md-6">
                                <label class="form-label">Religion</label>
                                <input type="text" class="form-control" name="religion" id="religion" placeholder="Enter Religion">
                            </div>
                
                            <!-- Caste -->
                            <div class="col-md-6">
                                <label class="form-label">Caste</label>
                                <input type="text" class="form-control" name="caste" id="caste" placeholder="Enter Caste">
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
                                <input type="text" class="form-control" name="occupation" id="occupation" placeholder="Enter the Occupation">
                            </div>
                
                            <!-- Location -->
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" id="location" placeholder="Enter the Location">
                            </div>
                
                            <!-- Monthly Income -->
                            <div class="col-md-12">
                                <label class="form-label">Monthly Income</label>
                                <input type="text" class="form-control" name="income" id="income" placeholder="Enter the Income">
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
@endsection

@section('script')

    {{-- Toaster --}}
    <script>
        document.getElementById('preferenceForm').addEventListener('submit', function (event) {
            // Prevent the form from submitting
            event.preventDefault();
        
            // Get all input fields
            const fields = [
                { id: 'partner_age', name: "Partner's Age" },
                { id: 'mother_tongue', name: "Mother Tongue" },
                { id: 'religion', name: "Religion" },
                { id: 'caste', name: "Caste" },
                { id: 'height', name: "Height" },
                { id: 'weight', name: "Weight" },
                { id: 'occupation', name: "Occupation" },
                { id: 'location', name: "Location" },
                { id: 'income', name: "Monthly Income" }
            ];
        
            // Array to store missing field names
            let missingFields = [];
        
            // Check each field
            fields.forEach(field => {
                const input = document.getElementById(field.id);
                if (!input.value.trim()) {
                    // Add missing field name to the array
                    missingFields.push(field.name);
                }
            });
        
            // If there are missing fields, show a single toaster message
            if (missingFields.length > 0) {
                // Join missing field names with a comma
                const errorMessage = `${missingFields.join(', ')} is required.`;
                // Show toaster message
                toastr.error(errorMessage, 'Validation Error');
            } else {
                // If all fields are valid, submit the form
                this.submit();
            }
        });
    </script>

    {{-- Form Submission AJAX --}}
    <script>
        document.getElementById('preferenceForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form default submission
    
            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });
    
            fetch('/matrimony/preference', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json()) // Ensure response is JSON
            .then(data => {
                if (data.success) {
                    alert('Preferences saved successfully!');
                    window.location.href = data.redirect_url; // Redirect to matrimony page
                } else {
                    alert('Failed to save preferences. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving preferences.');
            });
        });
    </script>    

@endsection