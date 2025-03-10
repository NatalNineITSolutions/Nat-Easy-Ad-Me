@extends('frontend.layout.master')
@section('site-title')
    {{ $listing->title }}
@endsection
@section('page-title')
    <?php
    $page_info = request()->url();
    $str = explode("/",request()->url());
    $page_info = $str[count($str)-2];
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
        .recentImg {
            height: 72px !important;
            width: 72px !important;
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
        img.no-image {
            /* width: auto; */
            max-width: 400px;
            margin: auto;
        }
        .btn-group-sm>.btn, .btn-sm {
            padding: .25rem 0;
            font-size: .875rem;
            border-radius: .2rem;
        }

        .slick_slider_item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: max-content;
        }

        .slick_slider_item a {
            display: flex;
            align-items: center;
            height: 40px;
            border-radius: 20px;
            background-color: rgb(243, 243, 247);
            padding: 8px 16px 8px 12px;
            font-size: 15px;
            font-weight: initial;
            line-height: 16px;
            letter-spacing: 0.25px;
            transition: all;
        }



        .sliderArrow {
            position: relative;
        }

        .sliderArrow .prev-icon,
        .sliderArrow .next-icon {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .sliderArrow .prev-icon {
            left: 10px; /* Adjust this value as needed */
        }

        .sliderArrow .next-icon {
            right: 10px; /* Adjust this value as needed */
        }

        .sliderArrow .prev-icon i,
        .sliderArrow .next-icon i {
            font-size: 24px; /* Adjust the size of the icon */
        }

        @media (max-width: 576px) {
            .sliderArrow .prev-icon,
            .sliderArrow .next-icon {
                width: 30px;
                height: 30px;
            }
            .sliderArrow .prev-icon i,
            .sliderArrow .next-icon i {
                font-size: 18px;
            }
        }

        .zoom-img {
            width: 100%;
            display: block;
        }

        .sliderArrow .prev-icon, .sliderArrow .next-icon {
            width: 30px;
            height: 30px;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.min.css')}}">
@endsection
@section('content')
    <!--Listing Details-->
    <div class="proDetails section-padding2">
        <div class="container-1310">
            <div class="bradecrumb-wraper-div">
                <x-breadcrumb.user-profile-breadcrumb
                    :title="''"
                    :innerTitle="__('Listing Details')"
                    :subInnerTitle="''"
                    :chidInnerTitle="''"
                    :routeName="'#'"
                    :subRouteName="'#'"
                />
                <x-validation.frontend-error/>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-8 ">
                    <div class="short-description">
                        <div class="left-part mb-4">
                            <div class="product-name-price">
                                <div class="product-name">{{ $listing->title }}</div>
                                <div class="right-part text-right">
                                    <div class="price text-end"><span>{{ float_amount_with_currency_symbol($listing->price) }}</span>
                                        @if($listing->negotiable === 1)
                                            <div class="token">{{ __('NEGOTIABLE') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="date-location">
                                <span>{{ __('Posted on') }}  <span class="posted">{{ \Carbon\Carbon::parse($listing->created_at)->format('j F Y') }}</span></span>
                                <span class="vartical-devider"></span>
                                <span>{{ get_static_option('listing_location_title') ?? __('Location') }}
                                     <span class="posted"> {{ userListingLocation($listing) }} </span>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Image Slider -->
                    <div class="product-view-wrap" id="myTabContent">
                        <div class="shop-details-gallery-slider global-slick-init slider-inner-margin sliderArrow"
                             data-asNavFor=".shop-details-gallery-nav"
                             data-infinite="true"
                             data-arrows="true"
                             data-dots="false"
                             data-slidesToShow="1"
                             data-swipeToSlide="true"
                             data-fade="true"
                             data-autoplay="false"
                             data-autoplaySpeed="3000"
                             data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                             data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                             data-responsive='[{"breakpoint": 1800,"settings": {"slidesToShow": 1}},{"breakpoint": 1600,"settings": {"slidesToShow": 1}},{"breakpoint": 1400,"settings": {"slidesToShow": 1}},{"breakpoint": 1200,"settings": {"slidesToShow": 1}},{"breakpoint": 991,"settings": {"slidesToShow": 1}},{"breakpoint": 768, "settings": {"slidesToShow": 1}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>

                        @if(!is_null($listing->gallery_images))
                                @php
                                    $thumb_image = $listing->image;
                                    $gallery_images = $listing->gallery_images;
                                    $all_images_list = $thumb_image . '|' . $gallery_images;
                                    $images = explode("|", $all_images_list);
                                @endphp
                                @foreach($images as $img)
                                    @if(!empty($img))
                                        <div class="single-main-image">
                                            <a href="#"
                                               data-mfp-src="{{ get_image_url_id_wise($img) }}"
                                               class="long-img image-link" tabindex="-1">
                                                {!! render_image_markup_by_attachment_id($img) !!}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="single-main-image">
                                    <a href="#" class="long-img">
                                        {!! render_image_markup_by_attachment_id($listing->image) !!}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <!-- Nav -->
                        @if(!is_null($listing->gallery_images))
                        <div class="thumb-wrap">
                            <div class="shop-details-gallery-nav global-slick-init slider-inner-margin sliderArrow"
                                 data-asNavFor=".shop-details-gallery-slider"
                                 data-focusOnSelect="true"
                                 data-infinite="false"
                                 data-arrows="false"
                                 data-dots="false"
                                 data-slidesToShow="6"
                                 data-autoplay="false"
                                 data-swipeToSlide="true"
                                 data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                                 data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                                 data-responsive='[{"breakpoint": 1200,"settings": {"slidesToShow": 5}}, {"breakpoint": 992,"settings": {"slidesToShow": 4}}, {"breakpoint": 450,"settings": {"slidesToShow": 3}}, {"breakpoint": 350,"settings": {"slidesToShow": 2}}]'>

                                @if(!is_null($listing->gallery_images))
                                    @php
                                        $thumb_image = $listing->image;
                                        $gallery_images = $listing->gallery_images;
                                        $all_images_list = $thumb_image . '|' . $gallery_images;
                                        $images = explode("|", $all_images_list);
                                    @endphp
                                    @foreach($images as $img)
                                        @if(!empty($img))
                                            <div class="single-thumb">
                                                <a class="thumb-link"
                                                   data-mfp-src="{{ get_image_url_id_wise($img) }}"
                                                   data-toggle="tab"
                                                   href="#image-{{$img}}">
                                                    {!! render_image_markup_by_attachment_id($img) !!}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    @if(!empty($listing->gallery_images))
                                        <div class="single-thumb">
                                            <a class="thumb-link" data-toggle="tab" href="#">
                                                {!! render_image_markup_by_attachment_id($listing->image) !!}
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Google Adds left-->
                    <div class="googleAdd-wraper after-product-slider">
                        <div class="add">
                            <div class="text-{{$right_custom_container}} single-banner-ads ads-banner-box" id="home_advertisement_store">
                                <input type="hidden" id="add_id" value="{{$right_add_id}}">
                                {!! $right_add_markup !!}
                            </div>
                        </div>
                    </div>

                    <!-- proDescription -->
                    <div class="proDescription box-shadow1">
                        <!-- Top -->
                        <div class="descriptionTop">
                            <div class="row gy-4">
                                @if(!empty($listing->condition))
                                <div class="col-4">
                                    {{ __('Condition:') }} <span class="text-bold"> {{ $listing->condition }} </span>
                                </div>
                                @endif
                                @if(!empty($listing->authenticity))
                                <div class="col-4">
                                    {{ __('Authenticity:') }} <span class="text-bold"> {{ $listing->authenticity }} </span>
                                </div>
                                @endif
                                @if(!empty($listing->brand))
                                    <div class="col-4">
                                        {{ __('Brand:') }} <span class="text-bold">{{ $listing->brand?->title }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- attributes -->
                        @if($listing->listing_attributes->isNotEmpty())
                        <div class="descriptionTop">
                            <div class="row gy-4">
                                <h5 class="disTittle"> {{ get_static_option('listing_attribute_section_title') ?? __('Attributes') }} </h5>
                                @foreach($listing->listing_attributes as $attribute)
                                    <div class="col-4">
                                        {{ $attribute->title }} <span class="text-bold"> {{ $attribute->description }} </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif


                        <div class="devider"></div>
                        <!-- Mid -->
                        <div class="descriptionMid">
                            <h4 class="disTittle">{{ get_static_option('listing_description_title') ?? __('Description') }}</h4>
                            <p class="pera" id="description">{!! Str::limit(str_replace('&nbsp;', ' ', strip_tags($listing->description)), 20000) !!}</p>
                            <button id="showMoreButton" class="show-more-btn">{{ __('Show More') }}</button>
                        </div>
                        <!-- Footer -->

                        <div class="descriptionFooter">
                            <h4 class="disTittle">{{ get_static_option('listing_tag_title') ?? __('Tags') }}</h4>
                            @if(isset($listing->tags) && count($listing->tags) > 0)
                                @if(!empty($listing->tags))
                                    <div class="tags">
                                        <form id="filter_with_listing_page_tag" action="{{ url(get_static_option('listing_filter_page_url') ?? '/listings') }}" method="get">
                                            <input type="hidden" name="tag_id" id="tag_id" value="" />
                                            @foreach($listing->tags as $tag)
                                                <a href="#" class="submit_form_listing_filter_tag" data-tag-id="{{ $tag->id }}">{{ $tag->name }}</a>
                                            @endforeach
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!--for mobile device user info -->
                    <div class="seller-part mt-3 d-md-none">
                        <x-listings.user-listing-phone-for-responsive :listing="$listing"/>
                        <x-listings.listing-details-page-user-info :listing="$listing" :userTotalListings="$user_total_listings"/>
                    </div>
                    <!--Relevant Ads-->
                    @include('frontend.pages.listings.relevant-listing')
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="seller-part">
                        <!--user info -->
                         <div class="d-none d-md-block">
                             <x-listings.user-listing-phone :listing="$listing"/>
                             <x-listings.listing-details-page-user-info :listing="$listing" :userTotalListings="$user_total_listings"/>
                         </div>
                        <!--Adds left-->
                        @if(get_static_option('google_adsense_status') == 'on')
                            <div class="googleAdd-wraper">
                                <div class="add">
                                    <div class="text-{{$custom_container}} single-banner-ads ads-banner-box" id="home_advertisement_store">
                                        <input type="hidden" id="add_id" value="{{$add_id}}">
                                        {!! $add_markup !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(get_static_option('safety_tips_info') !== null)
                            <div class="safety-tips">
                                <h3 class="head5">{{ get_static_option('listing_safety_tips_title') ?? __('Safety Tips') }}</h3>
                                <div class="safety-wraper">
                                    {!! get_static_option('safety_tips_info') !!}
                                </div>
                            </div>
                        @endif

                        <div class="share-on-wraper">
                            <div class="d-flex gap-3 align-items-center mb-3">
                                <div class="text-center w-50 report-btn listing-details-page-favorite">
                                    <x-listings.favorite-item-add-remove-for-details-page :favorite="$listing->id ?? 0" />
                                </div>
                                <div class="report-btn w-50 text-center">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reportModal">
                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 10H15L10.5 5.5L15 1H1V17" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                                    {!! single_post_share(route('frontend.listing.details',$listing->slug), $listing->title, $img_url) !!}
                                </span>
                            </div>
                        </div>

                        @include('frontend.pages.listings.frontend-business-hours')
                        @include('frontend.pages.listings.frontend-enquiry-form')

                        <div class="map-wraper box-shadow1">
                            <h3 class="head5">{{ __('Map') }}</h3>
                            <p>{{ $listing->address }}</p>
                            <div class="map">
                                @if (!empty(get_static_option("google_map_settings_on_off")))
                                    <div id="single-map-canvas" style="height: 230px; width: 100%; position: relative; overflow: hidden;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(!empty($listing->video_url))
                            <div class="map-wraper box-shadow1">
                                <h3 class="head5">{{ __('Video') }}</h3>
                                <iframe width="700" height="370"
                                        src="{{ 'https://www.youtube.com/embed/' . $listing->video_url }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.pages.listings.listing-report-add-modal')
    <x-frontend.login/>
@endsection
@section('scripts')
@if(!empty(get_static_option('google_map_settings_on_off')))
    <x-map.google-map-listing-details-page-js :lat="$listing->lat ?? 0" :lon="$listing->lon ?? 0"/>
@endif
@if($user_enquiry_form === true)
    <x-listings.enquiry-form-submit-js/>
@endif

<x-listings.listing-report-add-js/>
<script src="{{asset('assets/frontend/js/jquery.magnific-popup.min.js')}}"></script>
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){

                // Initialize Magnific Popup
                $('.image-link').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out'
                    }
                });


                let page = 1;
                $(document).on('click', '#load-more-ads', function() {
                    page++;
                    let listingId = $(this).data('listing-id');
                    $.ajax({
                        url: "{{ route('frontend.listing.load-more-relevant') }}",
                        type: "POST",
                        data: {
                            page: page,
                            listing_id: listingId
                        },
                        success: function(response) {
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
                        error: function(xhr) {
                        }
                    });
                });


                // Toggle for business hour
                $(".hours-wraper").slideToggle(300);
                $(".business-hour .business-head").on('click', function(){
                    $(".hours-wraper").slideToggle(300)
                });

                $(".enquiry-wraper").show();
                $(".enquiry-hour .enquiry-head").on('click', function() {
                    $(".enquiry-wraper").slideToggle(300);
                });

                let description = document.getElementById('description');
                let showMoreButton = document.getElementById('showMoreButton');
                $('#showMoreButton').show();
                let isExpanded = false;
                let originalContent = description.textContent;
                if (description.textContent.length > 700) {
                    description.textContent = description.textContent.substring(0, 700) + '...';
                }else {
                    $('#showMoreButton').hide();
                }
                showMoreButton.addEventListener('click', function() {
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
                $(document).on('click', '#userPhoneNumberBtn', function(event) {
                    event.preventDefault();
                    $('#default_phone_number_show').hide();
                    $('#phoneNumber').show();
                    $('.show-number').hide();
                });

                // for mobile responsive
                $('#phoneNumberForResponsive').hide();
                $('#default_phone_number_show_for_responsive').show();
                $(document).on('click', '#userPhoneNumberBtnForResponsive', function(event) {
                    event.preventDefault();
                    $('#default_phone_number_show_for_responsive').hide();
                    $('#phoneNumberForResponsive').show();
                    $('.show-number').hide();
                });

                // for mobile responsive with call to number
                $(document).on('click', '#phoneNumberForResponsive', function(event) {
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
