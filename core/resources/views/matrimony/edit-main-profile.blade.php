@extends('matrimony.layouts.app') 

@section('style')
    <style>

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }
        
        .profile-container {
            background-color: #FFFBEE;
            padding-top: 45px;
        }

        .main {
            border: 1px solid #F0F0F0;
            border-radius: 20px;
            padding: 20px 20px;
        }

        .main h2 {
            font-size: 14px;
            font-weight: 600;
        }

        form {
            margin-top: 25px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        label {
            font-size: 12px;
            font-weight: 600;
        }

        .form-control {
            font-size: 12px;
            font-weight: 500;
        }

        /* Hide arrows in number input for Chrome, Safari, Edge, and Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide arrows in number input for Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .profile-settings {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-secondary {
            font-size: 12px;
            font-weight: 600;
            border-radius: 25px;
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
                    <div class="profile-settings">
                        <h2 class="mb-0">Profile Settings</h2>
                        <a href="{{ route('matrimony.profile') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <form method="POST" action="{{ route('matrimony.update-profile', $userProfile->user_id) }}">
                        @csrf
                        @method('PUT')
                    
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{ $userProfile->username ?? '' }}" readonly>
                                </div>
                    
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" value="{{ $userProfile->education ?? '' }}">
                                </div>
                            </div>
                    
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" class="form-control" name="occupation" value="{{ $userProfile->occupation ?? '' }}">
                                </div>
                    
                                <div class="mb-3">
                                    <label class="form-label">Annual Income</label>
                                    <input type="number" class="form-control" name="annual_income" value="{{ $userProfile->annual_income ?? '' }}" style="appearance: textfield;">
                                </div>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>    
                </div>
            </main>
        </div>
    </div>
</div>

@endsection