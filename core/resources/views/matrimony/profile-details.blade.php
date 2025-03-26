@extends('matrimony.layouts.app')

@section('title', 'Matrimony Home')

@section('style')
    <style>
        /* Gradient Background */
        .pricing-section {
            background: linear-gradient(to right, #6d0f7b, #e44042);
            /* Adjusted Gradient Colors */
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
        }

        /* Small Decorative Circles */
        .pricing-section::before,
        .pricing-section::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .pricing-section::before {
            top: 20px;
            left: 30px;
        }

        .pricing-section::after {
            bottom: 30px;
            right: 40px;
        }

        /* Heading Styles */
        .pricing-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .pricing-section h3 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .pricing-section p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 10px auto;
        }

        /* Button Styling */
        .pricing-btn {
            background-color: white;
            color: #e44042;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            margin-top: 15px;
        }

        .pricing-btn:hover {
            background-color: #f5f5f5;
            color: #6d0f7b;
        }

        .profile-details {
            background: #FFFBEE;
            padding: 30px 0 60px 0;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
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
            ;
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

        .profile-wrapper {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgb(226, 226, 226);
            margin-top: 35px;
            width: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .profile-wrapper-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 60px;
        }

        .profile-pic {
            border-radius: 50%;
        }

        .profile-pic img {
            width: 80%;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-info h2 {
            font-size: 18px;
            font-weight: 600;
            text-align: left;
            color: #66451C;
        }

        .profile-info h3 {
            color: gray;
            font-size: 16px;
        }

        .details {
            text-align: left;
        }

        .details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .details span {
            font-weight: 600;
        }

        .connect-btn {
            margin-top: 20px;
            text-align: center;
        }

        .connect a {
            display: inline-block;
            padding: 10px 20px;
            background: #ffcc00;
            color: #333;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
        }

        .profile-bottom {
            margin-top: 40px;
        }

        .profile-tabs {
            border-bottom: 1px solid #E5E5E5;
            overflow-x: auto;
            /* Allow horizontal scrolling on small screens */
            white-space: nowrap;
            /* Prevent tabs from wrapping */
        }

        .tab-link {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            /* Ensure tabs are in a single line */
        }

        .tab-link.active {
            border-bottom: 3px solid #4CAF50;
            color: #4CAF50;
        }

        .tab-content {
            display: none;
            padding: 15px;
        }

        .tab-content.active {
            display: block;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 10px;
        }

        .gallery-grid img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .gallery-grid img:first-child {
            grid-column: span 2;
            /* First image takes 2 columns */
        }

        .gallery-grid img:nth-child(4) {
            grid-column: span 2;
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid img:first-child {
                grid-column: span 1;
            }
        }

        .download-btn {
            display: inline-block;
            background-color: #ff4081;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .download-btn:hover {
            background-color: #d81b60;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .pricing-section h2 {
                font-size: 2rem;
            }

            .pricing-section h3 {
                font-size: 1.5rem;
            }

            .profile-tabs {
                display: flex;
                flex-direction: column;
                /* Stack tabs vertically on small screens */
                border-bottom: none;
            }

            .tab-link {
                text-align: left;
                border-bottom: 1px solid #E5E5E5;
                width: 100%;
                /* Full width for vertical tabs */
            }

            .tab-link.active {
                border-bottom: 3px solid #4CAF50;
            }
        }


        @media (max-width: 600px) {
            .profile-card {
                width: 90%;
            }

            .profile-wrapper-section {
                flex-direction: column;
                gap: 30px;
            }

            .profile-info {
                align-self: flex-start;
            }
        }
    </style>

@endsection

@section('content')

    <section class="pricing-section">
        <h3>PROFILE DETAILS</h3>
        <h2>Get to Know</h2>
        <h3>Explore the Perfect Match</h3>
        <p>Discover detailed profiles and find a compatible partner. View preferences, interests, and essential details to
            make the right choice!</p>
        {{-- <a href="#" class="pricing-btn">See Available Pricing Plans</a> --}}
    </section>

    <div class="profile-details">
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
        </div>

        <div class="profile-wrapper container">
            <div class="profile-wrapper-section">
                <div class="profile-images-container">
                    @if($mainImageHtml)
                        <!-- Only show the first/main profile image -->
                        <div class="main-profile-image">
                            {!! $mainImageHtml !!}
                        </div>
                    @else
                        <!-- Default fallback -->
                        <div class="main-profile-image">
                            <img src="/assets/uploads/media-uploader/profile-detail.png" alt="Default Profile">
                        </div>
                    @endif
                </div>

                <div class="profile-info">
                    <div>
                        <h2>{{ $profile->name ?? 'User' }} <span>👑</span></h2>
                    </div>
                    <div class="details">
                        <p><span>Education:</span> {{ $profile->education ?? 'Not specified' }}</p>
                        <p><span>ID Number:</span> {{ $profile->id_number ?? 'N/A' }}</p>
                        <p><span>Address:</span> {{ $profile->address ?? 'Not specified' }}</p>
                        <p><span>Age & Religion:</span> {{ $profile->age ?? '' }}, {{ $profile->religion ?? '' }}</p>
                        <p><span>Occupation:</span> {{ $profile->occupation ?? 'Not specified' }}</p>
                    </div>
                    <div class="connect">
                        <a href="javascript:void(0);" onclick="showProfileDetails()">Unlock full details</a>
                    </div>
                </div>
            </div>

            <div class="profile-bottom" style="display: none;">
                <div class="profile-tabs">
                    <button class="tab-link active" data-tab="description"
                        onclick="openTab(event, 'description')">Descriptions</button>
                    <button class="tab-link" data-tab="gallery" onclick="openTab(event, 'gallery')">Gallery</button>
                    <button class="tab-link" data-tab="jothagam" onclick="openTab(event, 'jothagam')">Jathagam</button>
                </div>

                <div class="tab-content active" id="description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>

                <div class="tab-content" id="gallery">
                    <div class="gallery-grid">
                        @if(count($galleryImagesHtml) > 0)
                            @foreach($galleryImagesHtml as $imageHtml)
                                <div class="gallery-item">
                                    {!! $imageHtml !!}
                                </div>
                            @endforeach
                        @else
                            <p>No gallery images available</p>
                        @endif
                    </div>
                </div>

                <div id="jothagam" class="tab-content">
                    <p>Download the Jothagam PDF file:</p>
                    <a href="path/to/yourfile.pdf" download class="download-btn">Download PDF</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabLinks = document.querySelectorAll(".tab-link");
            const tabContents = document.querySelectorAll(".tab-content");

            function openTab(event, tabName) {
                tabContents.forEach(tab => {
                    tab.classList.remove("active");
                });

                tabLinks.forEach(btn => {
                    btn.classList.remove("active");
                });

                document.getElementById(tabName).classList.add("active");
                event.currentTarget.classList.add("active");
            }

            // Add event listeners to buttons
            tabLinks.forEach(tab => {
                tab.addEventListener("click", function () {
                    const tabName = this.getAttribute("data-tab");
                    openTab(event, tabName);
                });
            });
        });
    </script>

    <script>
        function showProfileDetails() {
            fetch("{{ route('matrimony.check.subscription') }}")
                .then(response => response.json())
                .then(data => {
                    console.log("Response Data:", data); // Debugging line

                    if (data.status === "success") {
                        document.querySelector('.profile-bottom').style.display = 'block';
                    } else {
                        toastr.error(data.message); // Show toast message

                        // Redirect to the pricing page after a short delay
                        setTimeout(() => {
                            window.location.href = "/matrimony/pricing";
                        }, 2000); // Redirect after 2 seconds
                    }
                })
                .catch(error => {
                    console.error("Fetch Error:", error);
                    toastr.error("Something went wrong. Please try again.");
                });
        }
    </script>
@endsection