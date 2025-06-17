@extends('frontend.layout.master')
@section('site-title')
    {{ __('Products') }}
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<style>
    .swiper-button-next,
    .swiper-button-prev {
        color: #EF4444;
        top: 35%;
    }

    .swiper {
        padding-bottom: 50px;
    }

    .swiper-slide {
        height: auto;
    }
</style>

@endsection

@section('content')
    <div class="profile-setting setting-page section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')

                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')

                            <div class="main-body">
                                <x-frontend.user.responsive-icon />

                                <div class="setting-btn-part">
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="tab-content-wraper box-shadow1 p-4">
                                                <h3 class="mb-5">{{ __('Products Slider Section') }}</h3>

                                                <div class="row">
                                                    @forelse($products as $product)
                                                        <div class="col-md-4 col-lg-3 mb-4">
                                                            <div class="card h-100 border-0" style="border: 1px solid #e5e7eb;">
                                                                <img src="{{ asset('uploads/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                                                <div class="card-body d-flex flex-column">
                                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                                    <p class="card-text text-muted mb-1">₹{{ $product->price }}</p>
                                                                    <a href="{{ route('user.product.details', $product->id) }}" class="btn btn-sm btn-primary mt-auto">View Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="col-12">
                                                            <div class="alert alert-info text-center">
                                                                {{ __('No products found.') }}
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>

                                            </div>
                                        </div>
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

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
        },
    });
</script>