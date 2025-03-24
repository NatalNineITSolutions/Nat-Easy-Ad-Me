@extends('matrimony.layouts.app') <!-- Extend main layout -->

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
            padding: 0px 20px;
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
                    <h2 class="mt-4">Profile Settings</h2>
    
                    <!-- Profile Info -->
                    <div class="profile-card d-flex align-items-center p-3">
                        {{-- <img src="{{ auth()->user()->profile_image ?? '/assets/uploads/matrimony/avatar.png' }}" alt="Profile" class="rounded-circle"> --}}
                        <div class="ms-3">
                            <h5>{{ auth()->user()->name }}</h5>
                            <p class="text-muted">Premium User | 1 Month</p>
                        </div>
                        <button class="btn btn-danger ms-auto">Sign Out</button>
                    </div>
    
                    <!-- Profile Visibility -->
                    <div class="profile-setting mt-4 p-3">
                        <h6>Profile Visible</h6>
                        <p class="text-muted">You can set who can view your profile.</p>
                        <select class="form-select w-auto">
                            <option>All Users</option>
                            <option>Only Matched Users</option>
                        </select>
                    </div>
    
                    <!-- Interest Requests -->
                    <div class="profile-setting mt-3 p-3">
                        <h6>Who can send you interest requests?</h6>
                        <p class="text-muted">You can set who can make interest requests here.</p>
                        <select class="form-select w-auto">
                            <option>All Users</option>
                            <option>Only Matched Users</option>
                        </select>
                    </div>
    
                    <!-- Account Details -->
                    <div class="account-details mt-4 p-3">
                        <h5>Account</h5>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong>Full Name:</strong> {{ auth()->user()->name }}</p>
                                <p><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Password:</strong> ********</p>
                                <p><strong>Profile Type:</strong> Platinum</p>
                                <button class="btn btn-outline-primary">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

@endsection