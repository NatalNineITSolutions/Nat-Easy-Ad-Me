@extends('frontend.layout.master')
@section('site-title')
    {{ __('Products') }}
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
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h3 class="mb-0">{{ __('Products Section') }}</h3>
                                                    <a href="{{ route('user.all.products') }}" class="btn btn-outline-primary btn-sm">
                                                        {{ __('View All') }}
                                                    </a>
                                                </div>
                                                <div class="row">
                                                    @forelse($products as $product)
                                                        <div class="col-md-4 col-lg-3 mb-4">
                                                            <div class="card h-100 border-0" style="border: 1px solid #e5e7eb;">
                                                                @php
                                                                    $imgPath = $product->imageFile->path ?? 'no-image.png';
                                                                @endphp
                                                                <img src="{{ asset('assets/uploads/media-uploader/' . $imgPath) }}"
                                                                class="card-img-top"
                                                                alt="{{ $product->name }}"
                                                                style="height: 200px; object-fit: contain;">
                                                                <div class="card-body d-flex flex-column">
                                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                                    <p class="card-text text-muted mb-1">₹{{ $product->distributor_price }}</p>
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

                                                {{-- 🔻 Pagination Links --}}
                                                <div class="row">
                                                    <div class="col-12 mt-4">
                                                        <div class="pagination-wrapper d-flex justify-content-center">
                                                            {{ $products->links('pagination::bootstrap-4') }}
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
        </div>
    </div>
@endsection