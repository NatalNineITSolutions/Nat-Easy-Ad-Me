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

                        <form action="{{ route('matrimony.submit-update-profile', $profile ? $profile->id : 0) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter Name" value="{{ $profile ? $profile->name : '' }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" id="age" name="age" class="form-control"
                                        placeholder="Enter Age" value="{{ $profile ? $profile->age : '' }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" class="form-control"
                                        placeholder="Enter Occupation" value="{{ $profile ? $profile->occupation : '' }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="annual_income" class="form-label">Annual Income</label>
                                    <input type="number" id="annual_income" name="annual_income" class="form-control"
                                        placeholder="Enter Annual Income" value="{{ $profile ? $profile->annual_income : '' }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Caste</label>
                                    <select class="form-select" name="caste" id="caste">
                                        <option value="" selected>Choose Caste</option>
                                        @foreach($castes as $caste)
                                            <option value="{{ $caste->id }}" {{ $profile && $profile->caste == $caste->id ? 'selected' : '' }}>{{ $caste->caste }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="motherTongue" class="form-label">Mother Tongue</label>
                                    <select class="form-select" id="motherTongue" name="motherTongue" required>
                                        <option value="">Choose Mother Tongue</option>
                                        @foreach($motherTongues as $tongue)
                                            <option value="{{ $tongue->mother_tongue }}" 
                                                {{ ($profile && $profile->mother_tongue == $tongue->mother_tongue) ? 'selected' : '' }}>
                                                {{ $tongue->mother_tongue }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="display: none;">
                                    @if($profile)
                                    Current DB value: {{ $profile->mother_tongue }}<br>
                                    @endif
                                    Submitted value: {{ old('motherTongue') }}
                                </div>                              
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="" selected>Choose Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $profile && $profile->country == $country->id ? 'selected' : '' }}>{{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-select" id="state" name="state" required>
                                        <option value="" selected>Choose State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ $profile && $profile->state == $state->id ? 'selected' : '' }}>{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-select" id="city" name="city" required>
                                        <option value="" {{ $profile && $profile->city ? '' : 'selected' }}>Choose City</option>
                                        @if($profile && $profile->city)
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $profile->city == $city->id ? 'selected' : '' }}>
                                                    {{ $city->city }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Upload Image</label>
                                    <p class="text-muted">Please upload files in jpg, jpeg, or png format and make sure the
                                        file size is under 25 MB.</p>

                                    <!-- Upload Box -->
                                    <div class="upload-box text-center p-4">
                                        <div class="upload-area">
                                            <img src="/assets/uploads/matrimony/upload.png" alt="Upload Icon"
                                                class="upload-icon">
                                            <p class="upload-text mb-0">Drop file or Browse</p>
                                            <p class="text-muted mb-0">Format: jpg, jpeg, png & Max file size: 25 MB</p>
                                            <input type="file" class="file-input" name="image" id="image"
                                                accept="image/jpg, image/jpeg, image/png"
                                                style="opacity: 0; position: absolute; z-index: -1;">
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
                                    <textarea id="description" name="description" class="form-control" placeholder="Enter description">{{ $profile ? $profile->description : '' }}</textarea>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </main>
@endsection