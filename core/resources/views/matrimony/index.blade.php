@extends('matrimony.layouts.app')

@section('title', 'Matrimony Home')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

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

        .search-container {
            background: rgba(0, 0, 0, 0.58);
            border-radius: 8px;
            padding: 15px;
            display: flex;
            gap: 10px;
            max-width: 1000px;
            margin: 20px auto;
        }

        .search-container select,
        .search-container button {
            width: 100%;
        }

        /* Tablet Design - 2 Column Layout */
        @media (max-width: 992px) {
            .banner-heading {
                font-size: 40px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .search-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                /* Space between elements */
                justify-content: space-between;
            }

            /* Default: 2 items per row for tablets */
            .search-container select,
            .search-container button {
                flex: 1 1 calc(50% - 10px);
                /* 50% width for 2 items per row */
                padding: 8px;
                font-size: 14px;
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

            .search-container {
                display: flex;
                flex-direction: column;
            }
        }

        /* Product slider */
        .card-slider {
            max-width: 960px;
            margin: 0 auto;

            @media screen and (max-width: 1024px) {
                width: 80%;
            }

            .slick-prev-icon,
            .slick-next-icon {
                color: black;
            }

            .card {
                position: relative;
                display: flex !important;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 15px;
                border-radius: 3px;
                border: 1px solid rgba(0, 0, 0, .2);
                background-color: white;
                text-decoration: none;
                color: rgba(0, 0, 0, .9);
                transition: all .1s linear;

                @media screen and (max-width: 600px) {
                    height: auto;
                }
            }

            .card h2 {
                font-size: 15px;
                font-weight: 600;
                text-align: center;
                margin-top: 15px;
                margin-bottom: 15px;
            }

            .card p {
                font-size: 12px;
                font-weight: 600;
            }

            /** Product title */
            .card .title {
                color: #000;
                margin: 0;
                padding: 10px 10px 5px 10px;
                font-size: 16px;
                font-weight: bold;
            }

            .card .title:hover {
                text-decoration: underline;
            }

            /** Product image */
            .card .image {
                /** Visually place the image above all other content (like the heading) in the parent flex container (.card). */
                order: -1;

                position: relative;
                height: 100px;
                padding: 2px;
                overflow: hidden;

                display: flex;
                justify-content: center;
                align-items: center;
            }

            .card .image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: grayscale(.5);
                transition: all .3s ease-in-out;
            }

            .card .image:hover img {
                width: 110%;
                height: 110%;
            }

            /** Product description */
            .card .description {
                margin: 7px 10px 15px 10px;
                font-size: 14px;
                opacity: .8;
            }

            /** Floating "sale" badge */
            .card .badge {
                position: absolute;
                top: 2px;
                right: 2px;
                z-index: 1;

                padding: 5px 10px;

                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
                color: white;
                background-color: rgb(200, 0, 0);
            }

            /** Price */
            .card .price {
                padding-left: 10px;
            }

            .card .price .new-price {
                font-weight: bold;
            }

            .card .price .original-price {
                margin-left: 5px;
                font-size: 14px;
                font-style: italic;
                opacity: .5;
                text-decoration: line-through;
            }

            /** Rating */
            .card .rating {
                margin: 10px 0 15px 10px;
                color: orange;
                font-size: 12px;
            }

            /** "30 reviews" link next to stars */
            .card .rating .reviews-link {
                color: rgba(0, 0, 0, .6);
                margin-left: 5px;
            }

            .card .rating .reviews-link:hover {
                color: black;
            }

            .card .rating .reviews-link:focus {
                color: royalblue;
                outline: 3px dotted royalblue;
                outline-offset: 2px;
            }

            /** Hover state = add box shadow, underline the title */
            .card:hover {
                border-color: rgba(0, 0, 0, .4);
                box-shadow: 0 0 10px 0 rgba(0, 0, 0, .15);
            }

            .card:hover .image img,
            .card:focus .image img {
                filter: grayscale(0);
            }

            .card a:focus {
                outline: none;
            }
        }

        .slick-next,
        .slick-prev {
            background-color: black;
        }

        .slick-next:hover,
        .slick-prev:hover {
            background-color: black;
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

        .card-slider {
            margin-top: 30px;
        }

        .card-profile {
            width: 60px;
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

        .slick-slide {
            margin: 0 5px;
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
        }

        /* Main container */
        .profile-container {
            margin: 30px auto 60px;
            max-width: 1200px;
            padding: 0 20px;
        }

        /* Card slider container */
        .card-slider-container {
            width: 100%;
            margin: 30px auto 0;
            position: relative;
        }

        /* Card slider styles */
        .card-slider {
            margin: 0 auto;
            max-width: 1000px;
            padding: 20px 0;
        }

        /* Individual card styling */
        .card {
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
            margin: 0 15px;
            /* Space between cards */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
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

        /* Slick slider customizations */
        .slick-slide {
            padding: 0 15px;
            /* This creates the space between cards */
        }

        .slick-list {
            margin: 0 -5px;
            /* Compensate for slide padding */
            padding: 20px 0;
        }

        .slick-track {
            display: flex;
            align-items: stretch;
            /* Make cards equal height */
        }

        /* Navigation arrows */
        .slick-prev,
        .slick-next {
            width: 40px;
            height: 40px;
            background: #C48C46;
            border-radius: 50%;
            z-index: 1;
        }

        .slick-prev {
            left: -50px;
        }

        .slick-next {
            right: -50px;
        }

        .slick-prev:before,
        .slick-next:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: white;
            font-size: 20px;
        }

        .slick-prev:before {
            content: '\f104';
        }

        .slick-next:before {
            content: '\f105';
        }

        /* Button styles */
        .btn-profile {
            display: inline-block;
            padding: 8px 20px;
            margin-top: 15px;
            background-color: #FF166C;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-profile:hover {
            background-color: #FF166C;
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .card-slider {
                max-width: 800px;
            }

            .slick-prev {
                left: -30px;
            }

            .slick-next {
                right: -30px;
            }
        }

        @media (max-width: 768px) {
            .card {
                margin: 0 10px;
                padding: 15px;
            }

            .card h2 {
                font-size: 16px;
            }

            .card p {
                font-size: 13px;
            }

            .card-profile {
                width: 70px;
                height: 70px;
            }
        }

        @media (max-width: 576px) {
            .card-slider {
                max-width: 300px;
            }

            .card {
                margin: 0 5px;
            }

            .slick-prev,
            .slick-next {
                width: 30px;
                height: 30px;
            }

            .slick-prev {
                left: -15px;
            }

            .slick-next {
                right: -15px;
            }
        }

        /* Force display of single card */
        .card-slider .slick-track {
            display: flex !important;
            gap: 15px;
        }

        .card-slider .slick-slide {
            float: none !important;
            height: auto !important;
        }

        /* Center single card */
        .card-slider .slick-list {
            overflow: visible;
            text-align: center;
        }

        .card-slider .card {
            margin: 0 auto;
        }

        /* Fallback style when only one card exists */
        .single-card-fallback {
            max-width: 300px;
            margin: 0 auto;
        }

        .single-card-fallback .card {
            width: 100% !important;
            float: none !important;
        }

        .card-slider .slick-slide {
            min-width: 280px !important;
            /* Your card's natural width */
            width: auto !important;
        }

        /* Fix for hidden initialization */
        .card-slider.slick-initialized {
            visibility: visible !important;
        }

        /* Container constraints */
        .card-slider {
            overflow: visible;
        }

        /* Perfect match */
        .perfect-match-banner {
            position: relative;
            margin-top: 30px;
            margin-bottom: 30px;
            background-color: #ffeebf;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .perfect-match-banner h1 {
            font-family: "Prociono", serif;
            color: #4a382f;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .perfect-match-banner p {
            color: #4a382f;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .perfect-match-banner-img {
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .register-now {
            padding: 10px 20px;
            background-color: black;
            color: #fff;
            border: none;
            outline: none;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        .support {
            padding: 10px 20px;
            border: 1px solid #000;
            background: transparent;
            outline: none;
            color: #000;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .illustration-container {
            overflow: hidden;
            /* Ensures the image stays inside the box */
            position: relative;
            /* Needed for proper positioning */
            width: 100%;
            /* Container width */
            height: auto;
            /* Auto height */
        }

        .illustration {
            width: 150%;
            /* Reduce image width for better fit */
            animation: scrollAnimation 15s linear infinite;
        }

        @keyframes scrollAnimation {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
                /* Moves half of the extended width */
            }
        }

        @media (max-width: 600px) {
            .perfect-match-banner h1 {
                font-size: 22px;
            }

            .perfect-match-banner p {
                font-size: 14px;
            }

            .buttons {
                flex-direction: column;
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
        }

        .details {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .profile-detail {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: black;
        }

        /* .card-profile {
            filter: blur(3px);
        } */

        .blurred {
            filter: blur(8px);
            -webkit-filter: blur(8px);
            transition: filter 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="banner">
        <div class="banner-bg"></div> <!-- Background for Zoom Effect -->
        <div class="banner-content">
            <img class="hibiscus" src="/assets/uploads/media-uploader/hibiscus.png" alt="Hibiscus">
            <h2 class="banner-heading">Find your <br> <span class="highlight">Right Match</span> here</h2>
            <p class="banner-desp">Forever Starts Here: Your Love, Your Journey, Your Wedding Wonderland!</p>
            <form action="{{ route('matrimony.searchresults') }}" method="GET" class="search-container">
                <select class="form-select" name="gender" id="search-gender">
                    <option selected disabled>I'm looking for</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            
                <select class="form-select" name="age" id="search-age">
                    <option selected disabled>Age</option>
                    <option value="18-25">18-25</option>
                    <option value="26-35">26-35</option>
                    <option value="36-45">36-45</option>
                </select>
            
                <input type="text" class="form-control" name="occupation" placeholder="Enter Occupation">
                <input type="text" class="form-control" name="location" placeholder="Enter Location">
            
                <button type="submit" class="btn btn-primary">Search</button>
            </form>           
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
        <div class="card-slider-container">
            <div class="card-slider">
                @forelse($profiles as $profile)
                    <div class="card">
                        @if (Str::startsWith($profile->first_image_url, '<img'))
                            <div class="card-profile">{!! $profile->first_image_url !!}</div>
                        @else
                            <img class="card-profile" src="{{ $profile->first_image_url }}" alt="{{ $profile->name }}">
                        @endif
                        <h2>{{ $profile->name }}</h2>
                        <p>📅 {{ $profile->age }} Years</p>
                        <p>💼 {{ $profile->occupation ?? 'Not specified' }}</p>
                        <p>📍 {{ $profile->city ?? 'Location not specified' }}</p>
                        <a href="{{ route('matrimony.profile-details', ['id' => $profile->id]) }}" class="btn-profile">View
                            Profile</a>
                    </div>
                @empty
                    <div class="card">
                        <h2>No Profiles Available</h2>
                        <p>Check back later for new matches</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <img class="grass-border" src="/assets/uploads/media-uploader/grass-border.png" alt="">

    <div class="container">
        <div class="perfect-match-banner">
            <h1>Find your perfect Match now</h1>
            <p>Discover your soulmate and build a beautiful future together. Start your journey today and find your perfect
                match with us!</p>
            <div class="buttons">
                <a href="/matrimony/profile-listing" class="register-link">
                    <button class="register-now">REGISTER NOW</button>
                </a>
                {{-- <button class="support">HELP & SUPPORT</button> --}}
            </div>
            <img class="perfect-match-banner-img" src="/assets/uploads/media-uploader/perfect-match-banner.png" alt="">
        </div>
    </div>

@endsection

@section('script')


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.card-slider').slick({
                dots: false,
                arrows: true,
                slidesToShow: 4,
                infinite: false,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1
                    }
                }
                ]
            });
        });
    </script>

    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.pushState(null, null, location.href);
        };
    </script>

    {{-- Search --}}
    <script>
        document.getElementById('search-btn').addEventListener('click', function () {
            const gender = document.getElementById('search-gender').value;
            const age = document.getElementById('search-age').value;
            const occupation = document.getElementById('search-occupation').value;
            const location = document.getElementById('search-location').value;
    
            fetch("{{ route('matrimony.matrimony.search') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ gender, age, occupation, location })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Matching Profiles:", data);
            })
            .catch(err => console.error("Search error:", err));
        });
    </script>    
@endsection