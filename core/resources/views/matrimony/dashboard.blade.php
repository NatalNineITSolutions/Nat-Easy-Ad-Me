@extends('matrimony.layouts.app') 

@section('style')
    <style>

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .main {
            border: 1px solid #F0F0F0;
            border-radius: 20px;
            padding: 20px 20px;
        }

        /* Profile matches */
        .profile-matches h2 {
            text-align: left;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            background-color: #FFFBEE;
            padding-top: 25px;
        }

        .profile-card {
            position: relative;
            width: 170px;
            height: 200px;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .profile-card .card-profile,
        .profile-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block; /* Ensures no extra space below image */
        }

        .profile-card .card-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-card:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
            opacity: 0.8;
        }

        .profile-info {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .profile-info h3 {
            margin: 5px 0;
            font-size: 15px;
            font-weight: 600;
        }

        .profile-info p {
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        .plan-details {
            margin-top: 30px;
        }

        .plan-details h2 {
            text-align: left;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .plan-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin: 20px auto;
            position: relative;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .card-header span {
            margin-bottom: 15px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-body img {
            width: 80px;
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
            font-size: 14px;
            text-align: left;
        }

        ul li {
            margin: 5px 0;
        }

        .highlight {
            font-weight: bold;
            color: #ff6b00;
        }

        .upgrade-btn {
            background: black;
            color: white;
            border: none;
            padding: 10px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            width: 30%;
            text-decoration: none;
            letter-spacing: 1.2px;
        }

        .upgrade-btn:hover {
            background: #333;
        }

        /* Tab */
        .interest-request h2 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            margin-top: 25px;
        }

        .tabs {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        .tab-button {
            padding: 8px 15px;
            border: none;
            background: #f4f4f4;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

        .tab-button.active {
            background: #28a745;
            color: white;
        }

        .menu-icon {
            cursor: pointer;
            color: #666;
            margin-left: auto;
        }

        .tab-content {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .tab-content.active {
            display: block;
        }

        .request-card {
            display: flex;
            align-items: center;
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-bottom: 1.5px solid rgba(231, 231, 231, 1);
        }

        .request-card img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-right: 15px;
        }

        .request-info {
            flex-grow: 1;
        }

        .request-info h3 {
            margin: 5px 0;
        }

        .request-info p {
            font-size: 14px;
            margin: 2px 0;
        }

        .profile-btn {
            background: none;
            border: 1px solid black;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-btn:hover {
            background: black;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .accept, .deny {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
        }

        .accept {
            background: #28a745;
            color: white;
            border-radius: 25px;
            font-weight: 600;
        }

        .deny {
            background: #dc3545;
            color: white;
            border-radius: 25px;
            font-weight: 600;
        } 

        .no-matches p {
            font-size: 14px;
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
                    <section class="profile-matches">
                        <h2>New Profiles Matches</h2>
                        <div class="profile-container">
                            @forelse($matches as $match)
                                <a href="{{ route('matrimony.profile-details', ['id' => $match->id]) }}" class="profile-card-link">
                                    <div class="profile-card">
                                        @if (Str::startsWith($match->first_image_url, '<img'))
                                            <div class="card-profile">{!! $match->first_image_url !!}</div>
                                        @else
                                            <img class="card-profile" src="{{ $match->first_image_url }}" alt="{{ $match->name }}">
                                        @endif
                                        <div class="overlay"></div>
                                        <div class="profile-info">
                                            <h3>{{ $match->name }}</h3>
                                            @if($match->occupation)
                                                <p class="occupation-match mb-0">{{ $match->occupation }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="no-matches">
                                    <p>No profiles found matching your preferred occupation</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section class="plan-details">
                        <h2 class="mb-0">Plan details</h2>
                        <div class="plan-card">
                            <div class="card-header">
                                <span>Standard Plan</span>
                            </div>
                            <div class="card-body">
                                <img src="/assets/uploads/matrimony/gift.png" alt="Gift Icon">
                                <ul>
                                    <li><strong>Plan name:</strong> Standard</li>
                                    <li><strong>Validity:</strong> <span class="highlight">6 Months</span></li>
                                    <li><strong>Valid till:</strong> <span class="highlight">24 June 2024</span></li>
                                </ul>
                                <a href="{{ route('matrimony.price') }}" class="upgrade-btn">UPGRADE NOW</a>
                            </div>
                        </div>
                    </section>

                    <section class="interest-request">
                        <h2>Interest Request</h2>
                        
                        <div class="tabs">
                            <button class="tab-button active" data-tab="new-requests">New requests</button>
                            <button class="tab-button" data-tab="accepted-requests">Accept request</button>
                            <button class="tab-button" data-tab="denied-requests">Deny request</button>
                        </div>
                
                        <div class="tab-content active" id="new-requests">

                            <div class="request-card">
                                <img src="/assets/uploads/matrimony/interest.png" alt="User Image">
                                <div class="request-info">
                                    <h3>John Smith</h3>
                                    <p><strong>City:</strong> Illinois <strong>Age:</strong> 21 <strong>Height:</strong> 5.7 <strong>Job:</strong> <span class="highlight">Working</span></p>
                                    <p>Request on: 10:30 A.M, 18 August 2024</p>
                                    <button class="profile-btn">View full profile</button>
                                </div>
                                <div class="action-buttons">
                                    <button class="accept">Accept</button>
                                    <button class="deny">Deny</button>
                                </div>
                            </div>
                        </div>
                
                        <div class="tab-content" id="accepted-requests">
                            <p>No accepted requests yet.</p>
                        </div>
                
                        <div class="tab-content" id="denied-requests">
                            <p>No denied requests yet.</p>
                        </div>
                
                    </section>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabButtons = document.querySelectorAll(".tab-button");
            const tabContents = document.querySelectorAll(".tab-content");

            tabButtons.forEach(button => {
                button.addEventListener("click", function() {
                    tabButtons.forEach(btn => btn.classList.remove("active"));
                    tabContents.forEach(content => content.classList.remove("active"));

                    this.classList.add("active");
                    document.getElementById(this.dataset.tab).classList.add("active");
                });
            });
        });
    </script>
@endsection