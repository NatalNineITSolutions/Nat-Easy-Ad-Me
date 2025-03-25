<div class="banner-forms">
    <form action="{{get_static_option('listing_filter_page_url') ?? '/listings'}}"
        class="d-flex align-items-center banner-search-location" method="get">

        <div class="banner-form-wrapper d-flex align-items-center">
            @if(!empty(get_static_option('google_map_settings_on_off')))
                <div class="new_banner__search__inputs">
                    <!-- <div class="new_banner__search__locationleft" id="myLocationGetAddress">
                            <i class="fa-solid fa-location-crosshairs fs-4 pr-5"></i>
                        </div> -->
                    <input class="form--control" name="change_address_new" id="change_address_new" type="hidden" value="">
                    <input class="banner-input-field" name="autocomplete" id="autocomplete" type="text"
                        placeholder="{{ __('Search location here') }}">
                </div>
            @endif

            <div class="search-with-any-text">
                <input class="banner-input-field" type="text" name="home_search" id="home_search"
                    placeholder="{{ __('What are you looking for?') }}">
                <div id="all_search_result" class="search-dropdown-results"></div>
            </div>

            <div class="banner-btns">
                <button type="submit" class="new-cmn-btn rounded-red-btn setLocation_btn border-0">
                    {{ get_static_option('search_button_title') ?? __('Search') }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Categorie Area  S t a r t-->
<div class="exploreCategories" data-padding-top="{{$padding_top}}" data-padding-bottom="{{$padding_bottom}}"
    style="background-color: {{$section_bg}}">
    <div class="container-1440">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-10 col-sm-10">
                <div class="section-tittle">
                    <h2 class="tittle">{{ $title }} </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="global-slick-init slider-inner-margin sliderArrow" data-infinite="true" data-arrows="true"
                    data-dots="false" data-rtl="{{get_user_lang_direction() == 'rtl' ? 'true' : 'false'}}"
                    data-slidesToShow="8" data-swipeToSlide="true" data-autoplay="false" data-autoplaySpeed="2500"
                    data-prevArrow='<div class="prev-icon"><i class="las la-angle-left"></i></div>'
                    data-nextArrow='<div class="next-icon"><i class="las la-angle-right"></i></div>'
                    data-responsive='[{"breakpoint": 1500,"settings": {"slidesToShow": 4}},{"breakpoint": 1600,"settings": {"slidesToShow": 4}},{"breakpoint": 1400,"settings": {"slidesToShow": 3}},{"breakpoint": 1200,"settings": {"slidesToShow": 3}},{"breakpoint": 991,"settings": {"slidesToShow": 2}},{"breakpoint": 768, "settings": {"slidesToShow": 2}},{"breakpoint": 576, "settings": {"slidesToShow": 1}}]'>
                    <!-- Single -->
                    @foreach($all_category as $category)
                        <div class="singleCategories categories{{$category->id}} wow fadeInUp" data-wow-delay="0.1s">
                            <div class="categoriIcon text-center">
                                <a href="{{ route('frontend.show.listing.by.category', $category->slug ?? 'x') }}"
                                    class="title">
                                    {!! render_image_markup_by_attachment_id($category->image) !!}
                                </a>
                            </div>
                            <div class="categorie-text">
                                <h4 class="text-center">
                                    <a href="{{ route('frontend.show.listing.by.category', $category->slug ?? 'x') }}"
                                        class="title oneLine mt-2"> {{ $category->name }} </a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End-of Categories -->


<style>
    .banner-forms {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .banner-form-wrapper {
        display: flex;
        flex-direction: row;
        gap: 10px;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        align-items: center;
    }

    .new_banner__search__inputs,
    .search-with-any-text {
        position: relative;
        flex: 1;
    }

    .banner-input-field {
        width: 400px;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .new_banner__search__locationleft {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #777;
        cursor: pointer;
    }

    .banner-btns {
        display: flex;
        align-items: center;
    }

    .new-cmn-btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        background: #e63946;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
        border: none;
    }

    .new-cmn-btn:hover {
        background: #d62839;
    }

    /* Search Dropdown Results Styling */
    .search-dropdown-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 0 0 6px 6px;
        border-top: none;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .search-dropdown-results.active {
        display: block;
    }

    .search-dropdown-results div {
        padding: 10px 15px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-dropdown-results div:hover {
        background: #f5f5f5;
    }

    .suggestion-items {
        display: flex;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .banner-form-wrapper {
            flex-direction: column;
            gap: 10px;
            width: 95%;
        }

        .banner-btns {
            width: 100%;
            text-align: center;
        }

        .new-cmn-btn {
            width: 100%;
        }

        .search-dropdown-results {
            position: relative;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 5px;
        }

        .banner-input-field {
            width: 100%;
        }

        .suggestion-items {
            display: block;
        }
    }
</style>