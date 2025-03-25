<style>
    .slider-image {
        width: 100% !important;
    }

    .slider-image img {
        width: 100% !important;
    }
</style>

<!-- Header Section -->
<div class="header-style-two" data-padding-top="{{$padding_top}}" data-padding-bottom="{{$padding_bottom}}"
    style="background-color: {{$header_background_color}};">
    <div class="container-1920 position-relative post">
        <!-- Automatic Background Slider -->
        <div class="header-slider">
            @if(isset($background_slider['background_images_']) && count($background_slider['background_images_']) > 0)
                @foreach ($background_slider['background_images_'] as $background_image)
                    @if(isset($background_image) && !empty($background_image))
                        <div class="slider-item">
                            <div class="slider-image">
                                {!! render_image_markup_by_attachment_id($background_image, '', 'full') !!}
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Header Content -->
        <div class="header-content">
            <div class="header-text text-center">
                <h1 class="header-title">{{ $title }}</h1>
                <p class="header-subtitle">{{ $subtitle }}</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {
            console.log('Initializing Automatic Slick Slider...');

            var $slider = $('.header-slider');

            if ($slider.length && $slider.find('.slider-item').length > 1) {
                console.log('Slider found with', $slider.find('.slider-item').length, 'slides');

                $slider.slick({
                    infinite: true,
                    speed: 1000,
                    fade: true,
                    cssEase: 'linear',
                    autoplay: true,
                    autoplaySpeed: 3000,
                    pauseOnHover: false,
                    pauseOnFocus: false,
                    arrows: false,
                    dots: false,
                });

                console.log('Slider initialized successfully.');
            } else {
                console.warn('Slider element not found or not enough slides.');
            }
        });
    })(jQuery);
</script>

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
@endpush