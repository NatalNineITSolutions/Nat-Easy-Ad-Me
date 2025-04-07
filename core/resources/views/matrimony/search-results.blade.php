@extends('matrimony.layouts.app')

@section('title', 'Matrimony Search')

@section('style')

    <style>
        .hibiscus {
            width: 90px;
            margin-bottom: 15px;
        }

        .banner-heading {
            font-family: "Prociono", serif;
            font-size: 60px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .banner-desp {
            font-size: 17px;
            font-weight: 400;
        }

        .banner {
            position: relative;
            height: 93vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 20px;
            overflow: hidden;
            /* Prevents horizontal scroll */
        }

        .banner-bg {
            background: url('/assets/uploads/media-uploader/ban-bg.jpg') no-repeat center center/cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            /* Zoom-in Animation */
            animation: zoomIn 3s ease-in infinite alternate;
        }

        @keyframes zoomIn {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
                /* Slight zoom-in effect */
            }
        }

        .grass-border {
            width: 100%;
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Dark overlay for better text visibility */
            z-index: 1;
        }

        .banner-content {
            width: 100%;
            position: relative;
            z-index: 2;
            /* Ensures content stays above background */
        }

        .profile-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 60px;
        }

        .dividers {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .dividers img {
            width: 90px;
        }

        .dividers img:nth-child(2) {
            transform: rotate(-180deg);
        }

        .profile-container-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-container-section-img {
            width: 120px;
        }

        .trusted-profiles {
            text-align: center;
        }

        .trusted-profiles h2 {
            font-size: 25px;
            color: #C48C46;
            margin-bottom: 10px;
        }

        .trusted-profiles p {
            font-size: 25px;
            font-weight: 600;
            color: #66451C;
        }

        .profile-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            width: 100%;
        }

        .card {
            width: 100%;
            max-width: 300px;
            position: relative;
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, .1);
            background-color: white;
            color: rgba(0, 0, 0, .9);
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
            flex: 1 1 calc(33.333% - 40px); /* 3 cards per row on desktop */
        }

        .card h2 {
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            margin: 15px 0 10px;
            color: #333;
        }

        .card p {
            font-size: 14px;
            font-weight: 500;
            margin: 5px 0;
            text-align: center;
            color: #555;
        }

        .card-profile {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f8f8f8;
        }

        .btn-profile {
            padding: 10px 15px;
            background-color: #FF166C;
            border: none;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: white;
            text-decoration: none;
            margin-top: 25px;
        }

        .btn-profile:hover {
            color: white;
        }

        .details {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .age,
        .occupation,
        .location {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .age,
        .occupation,
        .location  p {
            font-size: 14px;
            font-weight: 600;
        }

        /* Tablet Design - 2 Column Layout */
        @media (max-width: 992px) {
            .banner-heading {
                font-size: 40px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .dividers img {
                width: 60px;
            }

            .trusted-profiles h2 {
                font-size: 10px;
            }

            .trusted-profiles p {
                font-size: 10px;
            }

            .profile-container-section {
                gap: 5px;
            }

            .card {
                flex: 1 1 calc(50% - 30px);
            }
        }

        /* Mobile Design - Full Stack Layout */
        @media (max-width: 576px) {
            .banner-heading {
                font-size: 32px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .hibiscus {
                width: 60px;
                margin-bottom: 10px;
            }

            .card {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>
   
@endsection


@section('content')
    <div class="banner">
        <div class="banner-bg"></div> <!-- Background for Zoom Effect -->
        <div class="banner-content">
            <img class="hibiscus" src="/assets/uploads/media-uploader/hibiscus.png" alt="Hibiscus">
            <h2 class="banner-heading">Search <br> <span class="highlight">Results</span></h2>
            <p class="banner-desp">Here are the profiles that match your preferences. Start exploring now!</p>               
        </div>
    </div>

    <img class="grass-border" src="/assets/uploads/media-uploader/grass-border.png" alt="">

    <div class="container profile-container">
        <div class="profile-container-section">
            <img class="profile-container-section-img" src="/assets/uploads/media-uploader/profile-design.png" alt="">
            <div class="trusted-profiles">
                <div>
                    <h2>TRUSTED PROFILES</h2>
                    <p>More than 1500+ Trusted Profiles</p>
                </div>
                <div class="dividers">
                    <img src="/assets/uploads/media-uploader/divider.png" alt="">
                    <img src="/assets/uploads/media-uploader/divider.png" alt="">
                </div>
            </div>
            <img class="profile-container-section-img" src="/assets/uploads/media-uploader/profile-design.png" alt="">

            
        </div>

        <div class="profile-card-container">
            @forelse($matchedProfiles as $profile)
                <div class="card">
                    @if (Str::startsWith($profile->first_image_url, '<img'))
                        <div class="card-profile">{!! $profile->first_image_url !!}</div>
                    @else
                        <img class="card-profile" src="{{ $profile->first_image_url }}" alt="{{ $profile->name }}">
                    @endif
    
                    <h2>{{ $profile->name }}</h2>
                    <div class="details">
                        <div class="age">
                            <img src="/assets/uploads/matrimony/age.png" alt="">
                            <p>{{ $profile->age }} Years</p>
                        </div>
                        <div class="occupation">
                            <img src="/assets/uploads/matrimony/occupation.png" alt="">
                            <p>{{ $profile->occupation ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    
                    <div class="location">
                        <img src="/assets/uploads/matrimony/location.png" alt="">
                        <p>{{ $profile->city ?? 'Location not specified' }}</p>
                    </div>
                    
                    <a href="{{ route('matrimony.profile-details', ['id' => $profile->id]) }}" class="btn-profile">
                        View Profile
                    </a>
                </div>
            @empty
                <div class="card">
                    <h2>No Profiles Found</h2>
                    <p>Try different search filters</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection