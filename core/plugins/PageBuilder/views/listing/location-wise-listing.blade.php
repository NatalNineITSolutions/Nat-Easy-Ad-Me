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
            <form id="filter_with_listing_page_location" action="{{ url(get_static_option('listing_filter_page_url') ?? '/listings') }}" method="get">
                <input type="hidden" name="location" value="{{ $location }}"/>
                <input type="hidden" name="latitude" value="{{ $latitude }}"/>
                <input type="hidden" name="longitude" value="{{ $longitude }}"/>
                <a href="#" id="submit_form_listing_filter_location" class="see-all">{{ $explore_text }} <i class="las la-angle-right"></i></a>
            </form>
        </div>

        <div class="row">
            @foreach($listings as $listing)
                <div class="col-lg-4">
                    <x-listings.listing-single :listing="$listing"/>
                </div>
            @endforeach
        </div>
    </div>
</section>

@section('scripts')
    <script>
        document.getElementById('submit_form_listing_filter_location').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('filter_with_listing_page_location').submit();
        });
    </script>
@endsection