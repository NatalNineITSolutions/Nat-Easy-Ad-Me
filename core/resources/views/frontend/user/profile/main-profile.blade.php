@extends('frontend.layout.master')

@section('title', 'My Profile')

@section('style')
    <style>
        .profile-pages {
            padding: 30px 0;
        }

        .profile-setting-wraper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .down-body-wraper {
            display: flex;
            flex-wrap: wrap;
            padding: 30px;
        }

        .main-body {
            flex: 1;
            min-width: 0;
            padding-left: 30px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h3 {
            margin-bottom: 5px;
            color: #1e293b;
        }

        .profile-header p {
            color: #64748b;
        }

        .profile-section {
            margin-bottom: 30px;
        }

        .profile-section h5 {
            color: #1e293b;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        .profile-info p {
            margin-bottom: 8px;
            color: #334155;
            display: flex;
            flex-direction: column;
        }

        .profile-info strong {
            color: #1e293b;
            min-width: 150px;
            display: inline-block;
        }

        .profile-image-container {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .down-body-wraper {
                flex-direction: column;
                padding: 20px;
            }

            .main-body {
                padding-left: 0;
                margin-top: 20px;
            }

            .profile-info strong {
                min-width: 120px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="profile-setting profile-pages">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')
                        
                        <div class="down-body-wraper justify-content-center">
                            @include('frontend.user.layout.partials.sidebar')
                            
                            <div class="main-body">
                                <div class="profile-header">
                                    <h3>My Profile</h3>
                                    <p>PROFILE ID: {{ $profile['profile_id'] }}, SPONSOR ID: {{ $profile['sponsor_id'] }}</p>
                                </div>

                                <div class="row">
                                    <!-- Basic Info Section -->
                                    <div class="col-md-4 profile-section">
                                        <div class="profile-info">
                                            <h5>Basic Info</h5>
                                            <p><strong>Full Name:</strong> {{ $profile['full_name'] }}</p>
                                            <p><strong>DOB:</strong> {{ $profile['dob'] }}</p>
                                            <p><strong>Mobile Number:</strong> {{ $profile['mobile_number'] }}</p>
                                            <p><strong>Email:</strong> {{ $profile['email'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Personal Info Section -->
                                    <div class="col-md-4 profile-section">
                                        <div class="profile-info">
                                            <h5>Personal Info</h5>
                                            <p><strong>Gender:</strong> {{ $profile['gender'] }}</p>
                                            <p><strong>Whatsapp No:</strong> {{ $profile['whatsapp_no'] }}</p>
                                            <p><strong>Father/Husband:</strong> {{ $profile['father_husband_name'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Bank Details Section -->
                                    <div class="col-md-4 profile-section">
                                        <div class="profile-info">
                                            <h5>Bank Details</h5>
                                            <p><strong>Bank Name:</strong> {{ $profile['bank_name'] }}</p>
                                            <p><strong>Branch:</strong> {{ $profile['branch'] }}</p>
                                            <p><strong>IFSC Code:</strong> {{ $profile['ifsc_code'] }}</p>
                                            <p><strong>Account No:</strong> {{ $profile['account_no'] }}</p>
                                            <p><strong>Account Type:</strong> {{ $profile['account_type'] }}</p>
                                            <!-- Profile Image Section -->
                                            <div class="row">
                                                <div class="col-md-4 profile-section">
                                                    <h5>Profile Image</h5>
                                                    <div class="profile-image-container">
                                                    @if(!empty(Auth::guard('web')->user()->image))
                                                            {!! render_image_markup_by_attachment_id(Auth::guard('web')->user()->image,'','thumb') !!}
                                                        @else
                                                            <img src="{{ asset('assets/frontend/img/static/user-no-image.webp') }}" alt="No Image">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection