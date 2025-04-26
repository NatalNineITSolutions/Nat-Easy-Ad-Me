@extends('matrimony.layouts.app')

@section('title', 'Matrimony Home')

@section('style')
    <style>
        .hibiscus {
            width: 90px;
            margin-bottom: 15px;
        }

        .blurred {
            filter: blur(8px);
            -webkit-filter: blur(8px);
            transition: filter 0.3s ease;
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
        }

        .banner-bg {
            background: url('/assets/uploads/media-uploader/ban-bg.jpg') no-repeat center center/cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            animation: zoomIn 3s ease-in infinite alternate;
        }

        @keyframes zoomIn {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
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
            z-index: 1;
        }

        .banner-content {
            width: 100%;
            position: relative;
            z-index: 2;
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

        /* Profile Container - Updated */
        .profile-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 60px;
            width: 100%;
        }

        /* Cards Grid Layout */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Rest of your existing CSS remains the same */
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

        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            padding: 20px 15px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .btn-profile {
            display: inline-block;
            padding: 8px 20px;
            margin-top: 15px;
            background-color: #FF166C;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .btn-profile:hover {
            background-color: #FF166C;
            color: white;
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
            position: relative;
            width: 100%;
            height: auto;
        }

        .illustration {
            width: 150%;
            animation: scrollAnimation 15s linear infinite;
        }

        @keyframes scrollAnimation {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
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

        .user-details {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .details {
            width: 100%;
            display: flex;
            flex-direction: row;
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
        .location p {
            font-size: 14px;
            font-weight: 600;
        }

        /* Responsive Styles */
        @media (max-width: 1200px) {
            .cards-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            .banner-heading {
                font-size: 40px;
            }

            .banner-desp {
                font-size: 14px;
            }

            .search-container {
                flex-wrap: wrap;
                gap: 10px;
            }

            .search-container select,
            .search-container button {
                flex: 1 1 calc(50% - 10px);
                padding: 8px;
                font-size: 14px;
            }

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .card {
                padding: 15px;
            }

            .card h2 {
                font-size: 16px;
            }

            .card p {
                font-size: 13px;
            }
        }



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
                flex-direction: column;
            }

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

            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                padding: 10px;
            }

            .user-details {
                width: 100%;
            }

            .details{
                display: flex;
                flex-direction: column;
            }

            .location{
                margin-top: 8px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="banner">
        <div class="banner-bg"></div>
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
        <div class="cards-grid">
            @forelse($profiles as $profile)
                <div class="card">
                    @if (Str::startsWith($profile->first_image_url, '<img'))
                        <div>{!! str_replace('<img', '<img style="height: 100px;"', $profile->first_image_url) !!}</div>
                    @else
                        <img src="{{ $profile->first_image_url }}" alt="{{ $profile->name }}" style="height: 100px;">
                    @endif
                    <div class="mt-3 user-details">
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
                        <a href="{{ route('matrimony.profile-details', ['id' => $profile->id]) }}" class="btn-profile">View
                            Profile</a>
                    </div>
                </div>
            @empty
                <div class="card">
                    <h2>No Profiles Available</h2>
                    <p>Check back later for new matches</p>
                </div>
            @endforelse
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
            </div>
            <img class="perfect-match-banner-img" src="/assets/uploads/media-uploader/perfect-match-banner.png" alt="">
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function () {
            // Prevent back button issue
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.pushState(null, null, location.href);
            };
        });
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