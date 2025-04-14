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

        .request-info h4 {
            margin: 5px 0;
            font-size: 15px;
            font-weight: 600;
        }

        .request-info p {
            font-size: 13px;
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

        /* accept deny */
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
        }

        .status-badge.accepted {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            margin-top: 15px;
        }

        .accept {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .deny {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        } 

        .no-requests p {
            font-size: 15px;
            font-weight: 600;
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
            margin-top: 15px;
        }

        .modal {
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            cursor: pointer;
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

                    {{-- <section class="plan-details">
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
                    </section> --}}

                    {{-- <section class="plan-details">
                        <h2 class="mb-0">Plan details</h2>
                        @if($membershipInfo)
                            <div class="plan-card">
                                <div class="card-header">
                                    <span>{{ $membershipInfo['title'] }} Plan</span>
                                </div>
                                <div class="card-body">
                                    <img src="/assets/uploads/matrimony/gift.png" alt="Gift Icon">
                                    <ul>
                                        <li><strong>Plan name:</strong> {{ $membershipInfo['title'] }}</li>
                                        <li><strong>Profile Limit:</strong> <span class="highlight">{{ $membershipInfo['profile_limit'] }} profiles</span></li>
                                    </ul>
                                    <a href="{{ route('matrimony.price') }}" class="upgrade-btn">UPGRADE NOW</a>
                                </div>
                            </div>
                        @else
                            <div class="plan-card inactive">
                                <div class="card-header">
                                    <span>No Active Plan</span>
                                </div>
                                <div class="card-body">
                                    <img src="/assets/uploads/matrimony/gift.png" alt="Gift Icon">
                                    <ul>
                                        <li><strong>Status:</strong> <span class="highlight">Inactive</span></li>
                                        <li><strong>Please purchase a plan to access all features</span></li>
                                    </ul>
                                    <a href="#" class="upgrade-btn">GET STARTED</a>
                                </div>
                            </div>
                        @endif
                    </section> --}}
                    <section class="plan-details">
                        <h2 class="mb-0">My Plan</h2>
                        @if($membershipInfo)
                            <div class="plan-card">
                                <div class="card-header">
                                    <span>{{ $membershipInfo['title'] }}</span>
                                </div>
                                <div class="card-body">
                                    <img src="/assets/uploads/matrimony/gift.png" alt="Gift Icon">
                                    <ul>
                                        <li><strong>Profile Limit:</strong> 
                                            <span class="highlight">{{ $membershipInfo['profile_limit'] }} profiles</span>
                                        </li>
                                    </ul>
                                    <a href="{{ route('matrimony.price') }}" class="upgrade-btn">CHANGE PLAN</a>
                                </div>
                            </div>
                        @else
                            <div class="plan-card inactive">
                                <div class="card-header">
                                    <span>No Plan Active</span>
                                </div>
                                <div class="card-body">
                                    <img src="/assets/uploads/matrimony/gift.png" alt="Gift Icon">
                                    <ul>
                                        <li>You haven't subscribed to any plan yet</li>
                                    </ul>
                                    <a href="{{ route('matrimony.price') }}" class="upgrade-btn">CHOOSE A PLAN</a>
                                </div>
                            </div>
                        @endif
                    </section>

                    <section class="interest-request">
                        <h2>Interest Request</h2>
                        
                        <div class="tabs">
                            <button class="tab-button active" data-tab="new-requests">New requests</button>
                            <button class="tab-button" data-tab="accepted-requests">Accept request</button>
                            <button class="tab-button" data-tab="denied-requests">Deny request</button>
                        </div>

                        <div class="tab-content active" id="new-requests">
                            @forelse($receivedRequests as $request)
                                <div class="request-card" data-request-id="{{ $request->id }}">
                                    <div class="request-info">
                                        <h4>{{ $request->sender->username }} sent a request to:</h4>
                                        <p class="profile-name">{{ $request->profile->name }}</p>
                                        <p>
                                            <strong>Age:</strong> {{ $request->profile->age ?? 'N/A' }}
                                            <strong>Job:</strong> <span class="highlight">{{ $request->profile->occupation ?? 'N/A' }}</span>
                                        </p>
                                        <p>Request given on: {{ $request->created_at->format('d F Y') }}</p>
                                        <button class="btn-profile view-sender-profile"
                                            data-username="{{ $request->sender->username }}"
                                            data-email="{{ $request->sender->email }}"
                                            data-phone="{{ $request->sender->phone }}"
                                            data-created="{{ $request->sender->created_at->format('d M Y') }}"
                                            data-address="{{ $request->sender->identity_verify->address ?? 'N/A' }}">
                                            View Profile
                                        </button>
                                    </div>
                                    <div class="action-buttons">
                                        <button class="accept" data-request-id="{{ $request->id }}">Accept</button>
                                        <button class="deny" data-request-id="{{ $request->id }}">Deny</button>
                                    </div>
                                </div>
                            @empty
                                <div class="no-requests">
                                    <p class="mb-0">No new requests found</p>
                                </div>
                            @endforelse
                        </div>

                        <div id="senderProfileModal" class="modal" style="display: none;">
                            <div class="modal-content">
                                <span class="close-btn">&times;</span>
                                <h2>Sender Details</h2>
                                <p><strong>Username:</strong> <span id="modal-username"></span></p>
                                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                                <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                                <p><strong>Joined On:</strong> <span id="modal-created"></span></p>
                                <p><strong>Address:</strong> <span id="modal-address"></span></p>
                            </div>
                        </div>
                
                        <div class="tab-content" id="accepted-requests">
                            @forelse($acceptedRequests as $request)
                                <div class="request-card" data-request-id="{{ $request->id }}">
                                    <div class="request-info">
                                        <h4>{{ $request->sender->username }} sent a request to:</h4>
                                        <p class="profile-name">{{ $request->profile->name }}</p>
                                        <p>
                                            <strong>Age:</strong> {{ $request->profile->age ?? 'N/A' }}
                                            <strong>Job:</strong> <span class="highlight">{{ $request->profile->occupation ?? 'N/A' }}</span>
                                        </p>
                                        <p>Request given on: {{ $request->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="status-badge accepted">Accepted</div>
                                </div>
                            @empty
                                <div class="no-requests">
                                    <p>No accepted requests yet</p>
                                </div>
                            @endforelse
                        </div>
                
                        <div class="tab-content" id="denied-requests">
                            @forelse($rejectedRequests as $request)
                                <div class="request-card" data-request-id="{{ $request->id }}">
                                    <div class="request-info">
                                        <h4>{{ $request->sender->username }} sent a request to:</h4>
                                        <p class="profile-name">{{ $request->profile->name }}</p>
                                        <p>
                                            <strong>Age:</strong> {{ $request->profile->age ?? 'N/A' }}
                                            <strong>Job:</strong> <span class="highlight">{{ $request->profile->occupation ?? 'N/A' }}</span>
                                        </p>
                                        <p>Request given on: {{ $request->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="status-badge rejected">Rejected</div>
                                </div>
                            @empty
                                <div class="no-requests">
                                    <p>No rejected requests yet</p>
                                </div>
                            @endforelse
                        </div>
                
                    </section>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{-- Tab content --}}
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

    {{-- Accept and deny --}}
    <script>

        function updateNotificationCount(count) {
            const $badge = $('.fa-bell').siblings('.position-absolute');

            if(count > 0) {
                if($badge.length > 0) {
                    $badge.text(count);
                } else {
                    $('.fa-bell').after(`
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            ${count}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    `);
                }
            } else {
                $badge.remove();
            }
        }

        $(document).ready(function() {
            // Accept Request
            $(document).on('click', '.accept', function() {
                const requestId = $(this).data('request-id');
                const $card = $(this).closest('.request-card');
                
                $.ajax({
                    url: "{{ route('matrimony.request.accept') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: requestId
                    },
                    success: function(response) {
                        if(response.success) {
                            // Remove from new requests
                            $card.remove();
                            
                            // Update new requests empty state
                            if($('#new-requests .request-card').length === 0) {
                                $('#new-requests').html('<div class="no-requests"><p>No new requests found</p></div>');
                            }
                            
                            // Add to accepted requests
                            if($('#accepted-requests .no-requests').length > 0) {
                                $('#accepted-requests').empty();
                            }
                            
                            // Create accepted card
                            const $acceptedCard = $card.clone();
                            $acceptedCard.find('.action-buttons').remove();
                            $acceptedCard.append('<div class="status-badge accepted">Accepted</div>');
                            $('#accepted-requests').append($acceptedCard);

                            updateNotificationCount(response.newCount);
                        }
                    }
                });
            });

            // Deny Request
            $(document).on('click', '.deny', function() {
                if(confirm('Are you sure you want to reject this request?')) {
                    const requestId = $(this).data('request-id');
                    const $card = $(this).closest('.request-card');
                    
                    $.ajax({
                        url: "{{ route('matrimony.request.deny') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: requestId
                        },
                        success: function(response) {
                            if(response.success) {
                                // Remove from new requests
                                $card.remove();
                                
                                // Update new requests empty state
                                if($('#new-requests .request-card').length === 0) {
                                    $('#new-requests').html('<div class="no-requests"><p>No new requests found</p></div>');
                                }
                                
                                // Add to rejected requests
                                if($('#rejected-requests .no-requests').length > 0) {
                                    $('#rejected-requests').empty();
                                }
                                
                                // Create rejected card
                                const $rejectedCard = $card.clone();
                                $rejectedCard.find('.action-buttons').remove();
                                $rejectedCard.append('<div class="status-badge rejected">Rejected</div>');
                                $('#rejected-requests').append($rejectedCard);

                                updateNotificationCount(response.newCount);
                            }
                        }
                    });
                }
            });
        });
    </script>

    {{-- Show modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('senderProfileModal');
            const closeBtn = document.querySelector('.close-btn');

            document.querySelectorAll('.view-sender-profile').forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('modal-username').textContent = button.dataset.username || 'N/A';
                    document.getElementById('modal-email').textContent = button.dataset.email || 'N/A';
                    document.getElementById('modal-phone').textContent = button.dataset.phone || 'N/A';
                    document.getElementById('modal-created').textContent = button.dataset.created || 'N/A';
                    document.getElementById('modal-address').textContent = button.dataset.address || 'N/A';

                    modal.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target == modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endsection