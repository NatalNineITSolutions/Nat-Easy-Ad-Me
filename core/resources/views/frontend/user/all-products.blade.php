@extends('frontend.layout.master')
@section('site-title')
    {{ __('All Products') }}
@endsection

@section('content')
    <div class="profile-setting setting-page section-padding2">
        <div class="container-1920 plr1">
            <h3 class="mb-4">{{ __('All Products') }}</h3>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 border-0" style="border: 1px solid #e5e7eb;">
                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                 class="card-img-top"
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted mb-1">₹{{ $product->price }}</p>
                                <a href="{{ route('user.product.details', $product->id) }}"
                                   class="btn btn-sm btn-primary mt-auto">View Details</a>
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
@endsection