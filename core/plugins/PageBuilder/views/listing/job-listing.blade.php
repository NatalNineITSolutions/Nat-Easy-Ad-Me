<!-- Job Category Specific Listings Start -->
<section class="featureListing" data-padding-top="{{$padding_top}}" data-padding-bottom="{{$padding_bottom}}"
    style="background-color:{{$section_bg}}">
    <div class="container-1440">
        <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
            <h2 class="head3">{{ $section_title ?? 'Category Specific Listings' }}</h2>
            <form id="filter_with_listing_page_recent" action="{{ url('/listing/category/jobs') }}" method="get">
                <input type="hidden" name="sortby" value="latest_listing" />
                <a href="{{ url('/listing/category/jobs') }}" class="see-all">{{ $explore_text }} <i
                        class="las la-angle-right"></i></a>
            </form>
        </div>
        <div class="slider-inner-margin">
            <!-- Single -->
            @if($listings->count() > 0)
                @foreach($listings as $listing)
                    <div class="singleFeatureCard">
                        <div class="featureImg">
                            <x-listings.favorite-item-add-remove :favorite="$listing->id ?? 0" />
                            <a href="{{ route('frontend.listing.details', $listing->slug ?? '#') }}" class="main-card-image">
                                {!! render_image_markup_by_attachment_id($listing->image ?? null, '', 'thumb') !!}
                            </a>
                        </div>
                        <div class="featurebody">
                            <div class="card-body-top">
                                <h4>
                                    <a href="{{ route('frontend.listing.details', $listing->slug ?? '#') }}"
                                        class="featureTittle head4 twoLine">
                                        {{ $listing->title ?? __('No Title') }}
                                    </a>
                                </h4>
                            </div>

                            <x-listings.listing-location :listing="$listing" />

                            <div class="btn-wrapper">
                                @if($listing->is_featured === 1)
                                    <span class="pro-btn2">
                                        <svg width="7" height="10" viewBox="0 0 7 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0V3.88889H7L3 10V6.11111H0L4 0Z" fill="white" />
                                        </svg> {{ __('FEATURED') }}
                                    </span>
                                @endif
                            </div>

                            <span class="featurePricing d-flex justify-content-between align-items-center">
                                <span class="date">
                                    @if(!empty($listing->published_at))
                                        {{ \Carbon\Carbon::parse($listing->published_at)->diffForHumans() }}
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <p>{{ __('No listings found.') }}</p>
            @endif
        </div>
    </div>
</section>
<!-- End-of Job Category Specific Listings -->