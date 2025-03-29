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

        .profile-bottom {
            transition: all 0.3s ease;
        }

        .blurred {
            filter: blur(8px);
            transition: filter 0.3s ease;
        }

        .btn-profile {
            transition: all 0.3s ease;
        }

        .btn-profile:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .request {
            background-color: rgba(255, 22, 108, 1);
            border: none;
            outline: none;
            font-size: 12px;
            font-weight: 600;
        }

        .request:hover {
            background-color: rgba(255, 22, 108, 1);
        }

        .alert {
            font-size: 13px;
            font-weight: 600;
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
                <img class="profile-container-section-img " src="/assets/uploads/media-uploader/profile-design.png" alt="">
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
                <img class="profile-container-section-img " src="/assets/uploads/media-uploader/profile-design.png" alt="">
            </div>
        </div>

        <div class="profile-wrapper container">
            <div class="profile-wrapper-section">
                <div class="profile-images-container">
                    <!-- Main profile image - blurred if shouldBlur is true -->
                    <div class="main-profile-image">
                        {!! $mainImageHtml !!}
                    </div>
                </div>
                <div class="profile-info">
                    <div>
                        <h2>{{ $profile->name ?? 'User' }} <span>👑</span></h2>
                    </div>
                    <div class="details">
                        <p><span>Education:</span> {{ $profile->education ?? 'Not specified' }}</p>
                        <p><span>Age & Religion:</span> {{ $profile->age ?? '' }}, {{ $profile->religion ?? '' }}</p>
                        <p><span>Occupation:</span> {{ $profile->occupation ?? 'Not specified' }}</p>
                    </div>
                    <div class="profile-info">
                        <!-- ... profile info ... -->
                        @if(!$isUnlocked)
                            <div class="connect">
                                <a href="javascript:void(0);" onclick="unlockProfile()" class="btn-profile">Unlock full
                                    details</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$shouldBlur)
                <div class="profile-bottom" id="profileTabs" style="{{ $isUnlocked ? '' : 'display: none;' }}">
                    <div class="profile-tabs">
                        <button class="tab-link active" data-tab="description"
                            onclick="openTab(event, 'description')">Descriptions</button>
                        <button class="tab-link" data-tab="gallery" onclick="openTab(event, 'photos')">Photos</button>
                        <button class="tab-link" data-tab="contact" onclick="openTab(event, 'contact')">Contact</button>
                        <!-- <button class="tab-link" data-tab="jothagam" onclick="openTab(event, 'jothagam')">Jathagam</button> -->
                    </div>

                    <div class="tab-content active" id="description">
                        <p>{{ $profile->description ?? 'No description available' }}</p>
                    </div>

                    <div class="tab-content" id="contact">
                        @if($isUnlocked || !$shouldBlur)
                            <p><i class="fas fa-envelope"></i> {{ $userEmail ?? 'No email available' }}</p>
                            <p><i class="fas fa-phone"></i> {{ $userPhone ?? 'No phone available' }}</p>
                        @else
                            <div class="locked-contact-info">
                                <p><i class="fas fa-lock"></i> Contact information is locked</p>
                                <button onclick="unlockProfile()" class="btn btn-primary">
                                    Unlock Profile to View Contact Info
                                </button>
                            </div>
                        @endif
                        {{-- @if(!$isOwnProfile)
                            <button class="btn btn-primary request">
                                <i class="fas fa-paper-plane"></i> Send Request
                            </button>
                        @else
                            <div class="bg-light p-3 rounded mb-3 alert">
                                <i class="fas fa-user-shield me-2"></i> This profile was listed by you, so you can't send a request
                            </div>
                        @endif --}}
                        @if(!$isOwnProfile)
                            <form id="sendRequestForm" action="{{ route('matrimony.profile.send-request', $profile->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary request">
                                    <i class="fas fa-paper-plane"></i> Send Request
                                </button>
                            </form>
                        @else
                            <div class="bg-light p-3 rounded mb-3 alert">
                                <i class="fas fa-user-shield me-2"></i> This profile was listed by you
                            </div>
                        @endif
                    </div>

                    <div class="tab-content" id="gallery">
                        <div class="gallery-grid">
                            @if (count($galleryImagesHtml) > 0)
                                @foreach ($galleryImagesHtml as $imageHtml)
                                    <div class="gallery-item">
                                        {!! $imageHtml !!}
                                    </div>
                                @endforeach
                            @else
                                <p>No gallery images available</p>
                            @endif
                        </div>
                    </div>

                    <!-- <div id="jothagam" class="tab-content">
                        @if($profile->jothagam_path)
                            <p>Download the Jothagam PDF file:</p>
                            <a href="{{ asset($profile->jothagam_path) }}" download class="download-btn">Download PDF</a>s
                        @else
                            <p>No Jothagam available</p>
                        @endif
                    </div> -->
                </div>
            @endif
        </div>
    </div>

@endsection

@section('script')

    {{-- Toaster --}}
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };
    </script>

    {{-- Tab Component --}}
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

    {{-- Unlock Profile --}}
    <script>
        function unlockProfile() {
            const profileId = {{ $profile->id }};
            const unlockButton = document.querySelector('.btn-profile');

            // Disable button to prevent multiple clicks
            unlockButton.disabled = true;
            unlockButton.textContent = 'Processing...';

            fetch("{{ route('matrimony.unlock.profile') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ profile_id: profileId })
            })
                .then(response => {
                    if (response.redirected) {
                        // Handle redirect to pricing page
                        window.location.href = response.url;
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.status === "success") {
                        // Show the tabs section
                        document.getElementById('profileTabs').style.display = 'block';

                        // Remove blur from images
                        document.querySelectorAll('.blurred').forEach(img => {
                            img.classList.remove('blurred');
                        });

                        // Change button text or hide it
                        unlockButton.textContent = 'Unlocked';
                        setTimeout(() => {
                            unlockButton.style.display = 'none';
                        }, 1500);

                        // Reload the page after a short delay to ensure all changes are applied
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        unlockButton.disabled = false;
                        unlockButton.textContent = 'Unlock full details';
                        toastr.error(data.message || 'Failed to unlock profile');

                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        }
                    }
                })
                .catch(error => {
                    unlockButton.disabled = false;
                    unlockButton.textContent = 'Unlock full details';
                    toastr.error("Something went wrong. Please try again.");
                    console.error("Error:", error);
                });
        }

        function decrementProfileCount() {
            fetch("{{ route('decrement.profile') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }
    </script>

    {{-- Send request --}}
    {{-- <script>
        document.getElementById('sendRequestForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        // Your additional data if needed
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Request sent successfully!');
                    this.querySelector('button').disabled = true;
                } else {
                    alert(data.message || 'Error sending request');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        });
    </script> --}}

    <script>
        document.getElementById('sendRequestForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            button.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    toastr.success('Request sent successfully!');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-check"></i> Request Sent';
                } else {
                    toastr.error(data.message || 'Error sending request');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                toastr.error('An error occurred. Please try again.');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        });
    </script>
@endsection