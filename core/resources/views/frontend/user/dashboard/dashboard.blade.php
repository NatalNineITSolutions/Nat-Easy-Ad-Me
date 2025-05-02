@extends('frontend.layout.master')
@section('site_title')
    {{ __('Listing Favorite') }}
@endsection

@section('content')
    <div class="profile-setting my-account section-padding2">
        <div class="container-1920 plr1">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')
                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')
                            <div class="main-body">
                                <x-frontend.user.responsive-icon />
                                @if (moduleExists('Membership'))
                                    @if (membershipModuleExistsAndEnable('Membership'))
                                        @include('membership::frontend.user.membership.user-dashboard-membership-message')
                                    @endif
                                @endif

                                <!-- Referral and Business Stats -->
                                <div class="referral-business-stats">
                                    <div class="stats-grid">
                                        <div class="stats-card">
                                            <h4 class="stats-title">{{ __('Direct Business') }}</h4>
                                            <div class="stats-content">
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('ID Number:') }}</span>
                                                    <span class="stat-value">{{ $user->partner_id ?? __('N/A') }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Sponser ID:') }}</span>
                                                    <span class="stat-value">
                                                        {{ $referredBy }}{{ $referredById ? ' (' . $referredById . ')' : '' }}
                                                    </span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Placement ID:') }}</span>
                                                    <span class="stat-value">{{ $user->partner_id ?? __('N/A') }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Name:') }}</span>
                                                    <span class="stat-value">{{ $user->fullname }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Direct Business:') }}</span>
                                                    <span class="stat-value">{{ $directReferralsCount }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('BV from Direct Business:') }}</span>
                                                    <span class="stat-value">{{ number_format($bvFromReferrals) }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Direct Business Income:') }}</span>
                                                    <span class="stat-value">{{ $referralCommission }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="stats-card">
                                            <h4 class="stats-title">
                                                {{ __('Team Business') }}
                                                @if ($check_active_distributor == 1)
                                                    <span
                                                        style="color: green; display: inline-flex; align-items: center; margin-left: 5px;">
                                                        Active Distributor
                                                        <span
                                                            style="width: 8px; height: 8px; margin-left: 5px; background-color: green; border-radius: 50%; animation: pulse 1.5s infinite;"></span>
                                                    </span>
                                                @endif
                                            </h4>

                                            <div class="stats-content">
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Status:') }}</span>
                                                    <span class="stat-value">DISTRIBUTOR</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Self Purchase BV:') }}</span>
                                                    <span class="stat-value">{{ number_format($selfPurchasedBv) }}</span>
                                                </div>

                                                <!-- Team BV Left -->
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Team BV Left:') }}</span>
                                                    <div class="stat-value-group">
                                                        <span class="stat-value">{{ number_format($leftBvPoints) }}</span>
                                                    </div>
                                                </div>

                                                <!-- Team BV Right -->
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Team BV Right:') }}</span>
                                                    <div class="stat-value-group">
                                                        <span class="stat-value">{{ number_format($rightBvPoints) }}</span>
                                                    </div>
                                                </div>

                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Business Point (BP):') }}</span>
                                                    <span class="stat-value">{{ $balancedBP }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="stats-card">
                                            <h4 class="stats-title">{{ __('Income') }}</h4>
                                            <div class="stats-content">
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Total BP:') }}</span>
                                                    <span class="stat-value">{{ $totalBP }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Equalized BP:') }}</span>
                                                    <span class="stat-value">{{ $equalizedBP }}</span>
                                                </div>
                                                <div class="stat-item">
                                                    <span class="stat-label">{{ __('Balanced BP:') }}</span>
                                                    <span class="stat-value">{{ $balancedBP }}</span>
                                                </div>
                                                @if ($showIncome)
                                                    <div class="stat-item">
                                                        <span class="stat-label">{{ __('Income:') }}</span>
                                                        <span class="stat-value">{{ number_format($income) }}</span>
                                                    </div>
                                                @else
                                                    <div class="stat-item">
                                                        <span class="stat-label">{{ __('Income:') }}</span>
                                                        <span class="stat-value">{{ __('0') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Add Listing States-->
                                <div class="all-list-state mt-20">
                                    <div class="row g-3">
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-purple text-white">
                                                <h4 class="list-head">{{ $user_ads_posted }}</h4>
                                                <p class="post-state">{{ __('Ads Posted') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-cyan text-white">
                                                <h4 class="list-head">{{ $user_active_listings }}</h4>
                                                <p class="post-state">{{ __('Active Listing') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-orange text-white">
                                                <h4 class="list-head">{{ $remaining_listings ?? 0}}</h4>
                                                <p class="post-state">{{ __('Remaining Ad Listings') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-green text-white">
                                                <h4 class="list-head">{{ $user_deactivated_ads }}</h4>
                                                <p class="post-state">{{ __('Deactive Ads') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-blue text-white">
                                                <h4 class="list-head">{{ $user_favorite_ads }}</h4>
                                                <p class="post-state">{{ __('Favorite Ads') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-amber text-white">
                                                <h4 class="list-head">{{ $profilesViewed }}</h4>
                                                <p class="post-state">{{ __('Profile Viewed') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="list-state bg-red text-white">
                                            <h4 class="list-head">{{ $membershipInfo['profile_limit'] ?? 0 }}</h4>
                                                <p class="post-state">{{ __('Remaining Profile Limit') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 d-flex flex-column flex-lg-row gap-3">
                                    <a href="{{ route('user.team.view', auth()->user()->id) }}" class="team">
                                        {{ __('My Team View') }}
                                    </a>
                                    <a href="{{ route('user.genology') }}" class="genology">{{ __('Genology') }}</a>
                                    <a href="{{ route('user.referral.view', auth()->user()->id) }}"
                                        class="referral">{{ __('My Direct Team') }}</a>
                                </div>
                                <!--All Reviews-->
                                <div class="all-reviews box-shadow1 mt-20">
                                    <h4 class="dis-title">{{ __('All Reviews') }}</h4>
                                    <div class="review-tab-btn">
                                        <button class="review-recived me-4 active"
                                            data-target="#review-recived">{{ __('Reviews Received') }}</button>
                                        <button class="review-given"
                                            data-target="#review-given">{{ __('Reviews Given') }}</button>
                                    </div>
                                    <div class="review-wraper mt-20 active" id="review-recived">
                                        @if ($user->reviews)
                                            @php
                                                $review_type = 'received';
                                            @endphp
                                            <x-user.user-reviews :reviews="$user->reviews" :user="$user"
                                                :reviewtype="$review_type" />
                                        @endif
                                    </div>

                                    <div class="review-wraper mt-20" id="review-given">
                                        @if ($user_given_reviews)
                                            @php
                                                $review_type = 'given';
                                            @endphp
                                            <x-user.user-reviews :reviews="$user_given_reviews" :user="$user"
                                                :reviewtype="$review_type" />
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
@endsection
@section('scripts')
    <script src="{{ asset('assets/backend/js/sweetalert2.js') }}"></script>
@endsection

@section('style')
    <style>
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .referral-business-stats {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .stats-card {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stats-card.full-width {
            grid-column: 1 / -1;
        }

        .stats-title {
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
            color: #111827;
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .stats-content {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            color: #4b5563;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .stat-value {
            color: #111827;
            font-weight: 600;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-align: right;
        }

        .bg-purple {
            background-color: #9b27b0;
        }

        .bg-cyan {
            background-color: #00bcd4;
        }

        .bg-orange {
            background-color: #ff9800;
        }

        .bg-green {
            background-color: #00a65a;
        }

        .bg-blue {
            background-color: #0073b7;
        }

        .bg-red {
            background-color: #f56954;
        }

        .bg-amber {
            background-color: #ffc107;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .referral-business-stats {
                padding: 1rem 0;
            }

            .stats-card {
                padding: 1rem;
            }
        }

        .genology {
            background-color: #d9cc00;
            /* yellowish background */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .referral {
            background-color: #0f76d6;
            /* yellowish background */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .team {
            background-color: #d60f0f;
            /* yellowish background */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
@endsection