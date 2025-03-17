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
    {!!  render_page_meta_data_for_listing($listing) !!}
@endsection
@section('style')
    <style>
        h5.disTittle {
            font-size: 18px;
        }

        .phone_number_hide_show {
            display: flex;
            flex-direction: row-reverse;
            font-size: 18px;
            font-weight: 600;
            justify-content: flex-end;
            gap: 7px;
        }

        .select2-container {
            z-index: 900000;
        }

        .btn-group-sm>.btn,
        .btn-sm {
            padding: .25rem 0;
            font-size: .875rem;
            border-radius: .2rem;
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
                <div class="col-xl-8 col-lg-8 col-md-8 ">
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

                    <!-- proDescription -->
                    <div class="proDescription box-shadow1">
                        <!-- Top -->
                        <div class="descriptionTop">
                            <div class="row gy-4">
                                @if(!empty($listing->qualification))
                                    <div class="col-4">
                                        {{ __('Qualification:') }} <span class="text-bold"> {{ $listing->qualification }}
                                        </span>
                                    </div>
                                @endif
                                @if(!empty($listing->expected_salary))
                                    <div class="col-4">
                                        {{ __('Expected Salary:') }} <span class="text-bold"> {{ $listing->expected_salary }}
                                        </span>
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
                                {!! Str::limit(str_replace('&nbsp;', ' ', strip_tags($listing->description)), 20000) !!}
                            </p>
                            <button id="showMoreButton" class="show-more-btn">{{ __('Show More') }}</button>
                        </div>
                    </div>

                    <!--for mobile device user info -->
                    <div class="seller-part mt-3 d-md-none">
                        <x-listings.user-listing-phone-for-responsive :listing="$listing" />
                        <x-listings.listing-details-page-user-info :listing="$listing"
                            :userTotalListings="$user_total_listings" />
                    </div>
                    <!--Relevant Ads-->
                    @include('frontend.pages.listings.relevant-listing')
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="seller-part">
                        <!--user info -->
                        <div class="d-none d-md-block">
                            <x-listings.user-listing-phone :listing="$listing" />
                            <x-listings.listing-details-page-user-info :listing="$listing"
                                :userTotalListings="$user_total_listings" />
                        </div>

                        <div class="share-on-wraper">
                            <div class="d-flex gap-3 align-items-center mb-3">
                                <div class="text-center w-50 report-btn listing-details-page-favorite">
                                    <x-listings.favorite-item-add-remove-for-details-page :favorite="$listing->id ?? 0" />
                                </div>
                                <div class="report-btn w-50 text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reportModal">
                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 10H15L10.5 5.5L15 1H1V17" stroke="#64748B" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span id="addReportModal">{{ __('Report') }}</span>
                                    </a>
                                </div>
                            </div>

                            <div class="share-on">
                                <span class="social-icons">
                                    @php
                                        $image_url = get_attachment_image_by_id($listing->image);
                                        $img_url = $image_url['img_url'] ?? '';
                                     @endphp
                                    {!! single_post_share(route('frontend.listing.details', $listing->slug), $listing->title, $img_url) !!}
                                </span>
                            </div>
                        </div>

                        @include('frontend.pages.listings.frontend-enquiry-form')

                        <div class="map-wraper box-shadow1">
                            <h3 class="head5">{{ __('Map') }}</h3>
                            <p>{{ $listing->address }}</p>
                            <div class="map">
                                @if (!empty(get_static_option("google_map_settings_on_off")))
                                    <div id="single-map-canvas"
                                        style="height: 230px; width: 100%; position: relative; overflow: hidden;">
                                    </div>
                                @endif
                            </div>
                        </div>
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
        (function ($) {
            "use strict";

            $(document).ready(function () {

                let page = 1;
                $(document).on('click', '#load-more-ads', function () {
                    page++;
                    let listingId = $(this).data('listing-id');
                    $.ajax({
                        url: "{{ route('frontend.listing.load-more-relevant') }}",
                        type: "POST",
                        data: {
                            page: page,
                            listing_id: listingId
                        },
                        success: function (response) {
                            if (response.html) {
                                $('.relevant-listing-wrapper').append(response.html);
                            }

                            // Check if total relevant items is 0
                            if (response.total_relevant_items === 0) {
                                $('#load-more-ads').prop('disabled', true); // Disable the button
                                $('#load-more-ads').hide(); // hide the button
                            } else {
                                $('#load-more-ads').prop('disabled', false); // Enable the button
                            }

                        },
                        error: function (xhr) {
                        }
                    });
                });

                let description = document.getElementById('description');
                let showMoreButton = document.getElementById('showMoreButton');
                $('#showMoreButton').show();
                let isExpanded = false;
                let originalContent = description.textContent;
                if (description.textContent.length > 700) {
                    description.textContent = description.textContent.substring(0, 700) + '...';
                } else {
                    $('#showMoreButton').hide();
                }
                showMoreButton.addEventListener('click', function () {
                    if (!isExpanded) {
                        description.textContent = originalContent;
                        showMoreButton.textContent = 'Show Less';
                    } else {
                        description.textContent = description.textContent.substring(0, 700) + '...';
                        showMoreButton.textContent = 'Show More';
                    }
                    isExpanded = !isExpanded;
                });


                // for web
                $('#phoneNumber').hide();
                $('#default_phone_number_show').show;
                $('.show-number').show();
                $(document).on('click', '#userPhoneNumberBtn', function (event) {
                    event.preventDefault();
                    $('#default_phone_number_show').hide();
                    $('#phoneNumber').show();
                    $('.show-number').hide();
                });

                // for mobile responsive
                $('#phoneNumberForResponsive').hide();
                $('#default_phone_number_show_for_responsive').show();
                $(document).on('click', '#userPhoneNumberBtnForResponsive', function (event) {
                    event.preventDefault();
                    $('#default_phone_number_show_for_responsive').hide();
                    $('#phoneNumberForResponsive').show();
                    $('.show-number').hide();
                });

                // for mobile responsive with call to number
                $(document).on('click', '#phoneNumberForResponsive', function (event) {
                    event.preventDefault();
                    let phoneNumber = $('#phoneNumber').text().trim();
                    let tempLink = document.createElement('a');
                    tempLink.href = 'tel:' + phoneNumber;
                    document.body.appendChild(tempLink);
                    tempLink.trigger('click');
                    document.body.removeChild(tempLink);
                });

            });
        })(jQuery);
    </script>
@endsection