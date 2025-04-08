@extends('frontend.layout.master')
@section('site-title')
    {{ $listing->title }}
@endsection
@section('page-title')
    <?php
    $page_info = request()->url();
    $str = explode("/", request()->url());
    $page_info = $str[count($str) - 2];
        ?>
    {{ __(ucwords(str_replace("-", " ", $page_info))) }}
@endsection
@section('inner-title')
    {{ $listing->title}}
@endsection
@section('page-meta-data')
    {!! render_page_meta_data_for_listing($listing) !!}
@endsection
@section('style')
    <style>
        /* Your existing styles */
        .job-seeker-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .job-seeker-detail {
            margin-bottom: 15px;
        }

        .job-seeker-detail strong {
            display: inline-block;
            min-width: 150px;
        }
    </style>
@endsection
@section('content')
    <!--Listing Details-->
    <div class="proDetails section-padding2">
        <div class="container-1310">
            <div class="bradecrumb-wraper-div">
                <x-breadcrumb.user-profile-breadcrumb :title="''" :innerTitle="__('Listing Details')" :subInnerTitle="''"
                    :chidInnerTitle="''" :routeName="'#'" :subRouteName="'#'" />
                <x-validation.frontend-error />
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="short-description">
                        <div class="left-part mb-4">
                            <div class="product-name-price">
                                <div class="product-name">{{ $listing->title }}</div>
                            </div>
                            <div class="date-location">
                                <span>{{ __('Posted on') }} <span
                                        class="posted">{{ \Carbon\Carbon::parse($listing->created_at)->format('j F Y') }}</span></span>
                                <span class="vartical-devider"></span>
                                <span>{{ get_static_option('listing_location_title') ?? __('Location') }}
                                    <span class="posted"> {{ userListingLocation($listing) }} </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Job Seeker Specific Content -->
                    @if($listing->listing_type === 'job_seeker' && isset($listing->jobDetails))
                        <div class="job-seeker-section box-shadow1">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($listing->jobDetails->image)
                                        <img src="{{ asset($listing->jobDetails->image) }}" class="img-fluid rounded mb-3"
                                            alt="Profile Picture">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mb-3">{{ __('Professional Summary') }}</h4>
                                    <p>{{ $listing->jobDetails->summary }}</p>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Email:') }}</strong>
                                                <span>{{ $listing->jobDetails->email }}</span>
                                            </div>
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Expected Salary:') }}</strong>
                                                <span>{{ amount_with_currency_symbol($listing->jobDetails->expected_salary) }}</span>
                                            </div>
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Work Preference:') }}</strong>
                                                <span>{{ ucfirst($listing->jobDetails->work_preference) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Availability:') }}</strong>
                                                <span>{{ \Carbon\Carbon::parse($listing->jobDetails->availability_date)->format('j F Y') }}</span>
                                            </div>
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Relocation:') }}</strong>
                                                <span>{{ $listing->jobDetails->relocation_willingness ? __('Yes') : __('No') }}</span>
                                            </div>
                                            <div class="job-seeker-detail">
                                                <strong>{{ __('Work Authorization:') }}</strong>
                                                <span>{{ $listing->jobDetails->work_authorization }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Experience Section -->
                        <div class="proDescription box-shadow1 mt-4">
                            <h4 class="disTittle">{{ __('Work Experience') }}</h4>
                            <div class="description-content">
                                {!! $listing->jobDetails->work_experience !!}
                            </div>
                        </div>

                        <!-- Education Section -->
                        <div class="proDescription box-shadow1 mt-4">
                            <h4 class="disTittle">{{ __('Education') }}</h4>
                            <div class="description-content">
                                {!! $listing->jobDetails->education !!}
                            </div>
                        </div>

                        <!-- Skills Section -->
                        <div class="proDescription box-shadow1 mt-4">
                            <h4 class="disTittle">{{ __('Skills') }}</h4>
                            <div class="description-content">
                                {!! $listing->jobDetails->skills !!}
                            </div>
                        </div>

                        <!-- Additional Sections -->
                        @if($listing->jobDetails->certifications)
                            <div class="proDescription box-shadow1 mt-4">
                                <h4 class="disTittle">{{ __('Certifications') }}</h4>
                                <div class="description-content">
                                    {!! $listing->jobDetails->certifications !!}
                                </div>
                            </div>
                        @endif

                        @if($listing->jobDetails->projects)
                            <div class="proDescription box-shadow1 mt-4">
                                <h4 class="disTittle">{{ __('Projects') }}</h4>
                                <div class="description-content">
                                    {!! $listing->jobDetails->projects !!}
                                </div>
                            </div>
                        @endif

                        @if($listing->jobDetails->portfolio_links)
                            <div class="proDescription box-shadow1 mt-4">
                                <h4 class="disTittle">{{ __('Portfolio Links') }}</h4>
                                <div class="description-content">
                                    {!! $listing->jobDetails->portfolio_links !!}
                                </div>
                            </div>
                        @endif

                    @else
                        <!-- Regular Listing Content -->
                        <div class="proDescription box-shadow1">
                            <!-- Top -->
                            <div class="descriptionTop">
                                <div class="row gy-4">
                                    @if(!empty($listing->qualification))
                                        <div class="col-4">
                                            {{ __('Qualification:') }} <span class="text-bold"> {{ $listing->qualification }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($listing->expected_salary))
                                        <div class="col-4">
                                            {{ __('Expected Salary:') }} <span class="text-bold">
                                                {{ $listing->expected_salary }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($listing->location))
                                        <div class="col-4">
                                            {{ __('Location:') }} <span class="text-bold">{{ $listing->location }}</span>
                                        </div>
                                    @endif
                                    @if(!empty($listing->experience))
                                        <div class="col-4">
                                            {{ __('Experience:') }} <span class="text-bold">{{ $listing->experience }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="devider"></div>
                            <!-- Mid -->
                            <div class="descriptionMid">
                                <h4 class="disTittle">{{ get_static_option('listing_description_title') ?? __('Description') }}
                                </h4>
                                <p class="pera" id="description">
                                    {!! Str::limit(str_replace('&nbsp;', ' ', strip_tags($listing->summary)), 20000) !!}
                                </p>
                                <!-- <button id="showMoreButton" class="show-more-btn">{{ __('Show More') }}</button> -->
                                <a href="{{ route('job-seeker.resume', $listing->id) }}" class="btn btn-primary mb-3"
                                    target="_blank">
                                    {{ __('Show Profile') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Common Elements -->
                    <!--for mobile device user info -->
                    <div class="seller-part mt-3 d-md-none">
                        <x-listings.user-listing-phone-for-responsive :listing="$listing" />
                    </div>
                </div>

                <!-- Right Sidebar (common for both types) -->
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="seller-part">
                        <!--user info -->
                        <div class="seller-phone text-center">
                            <p>{{ __('Phone') }}</p>

                            {{-- Masked number by default --}}
                            <span class="number" id="maskedNumber">
                                {{ __('+880 XXX XXX XX') }}
                            </span>

                            {{-- Real number (hidden initially) --}}
                            @if(!$listing->phone_hidden)
                                <div class="number d-none" id="realPhoneNumber">
                                    {{ $listing->phone }}
                                </div>

                                {{-- Show number button --}}
                                <a href="#" class="show-number" id="showPhoneNumberBtn">
                                    {{ __('Show Number') }}
                                </a>
                            @endif
                        </div>

                        <div class="share-on-wraper">
                            <!-- Your existing share and favorite buttons -->
                        </div>

                        @include('frontend.pages.listings.frontend-enquiry-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.pages.listings.listing-report-add-modal')
    <x-frontend.login />
@endsection

@section('scripts')
    @if(!empty(get_static_option('google_map_settings_on_off')))
        <x-map.google-map-listing-details-page-js :lat="$listing->lat ?? 0" :lon="$listing->lon ?? 0" />
    @endif
    @if($user_enquiry_form === true)
        <x-listings.enquiry-form-submit-js />
    @endif

    <x-listings.listing-report-add-js />
    <script>
        // Your existing JavaScript
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const showBtn = document.getElementById('showPhoneNumberBtn');
            const maskedNumber = document.getElementById('maskedNumber');
            const realNumber = document.getElementById('realPhoneNumber');

            if (showBtn && maskedNumber && realNumber) {
                showBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Hide the masked number
                    maskedNumber.classList.add('d-none');

                    // Show the real number
                    realNumber.classList.remove('d-none');

                    // Hide the button itself
                    showBtn.classList.add('d-none');
                });
            }
        });
    </script>
@endsection