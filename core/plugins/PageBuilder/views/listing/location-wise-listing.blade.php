<!-- resources/views/listing/google-location-listing.blade.php -->
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
    <style>
        /* Add your custom styles here */
        .slider-kilometer .slider-range {
            height: 8px;
            background: #ddd;
        }
        .noUi-handle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--main-color-one);
        }
        .noUi-connect {
            background: gray;
        }
    </style>
@endsection

<section class="featureListing" data-padding-top="{{$padding_top}}" data-padding-bottom="{{$padding_bottom}}" style="background-color:{{$section_bg}}">
    <div class="container-1440">
        <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
            <h2 class="head3">{{ $section_title ?? 'Location Listing' }}</h2>
          
        </div>

        <div class="slider-inner-margin">
            <!-- Single -->
            <x-listings.listing-single-list-view :listings="$listings"/>
        </div>
    </div>
</section>