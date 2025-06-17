@extends('frontend.layout.master')

@section('site-title')
    {{ __('Product Details') }}
@endsection

@section('style')
<style>
    .product-detail-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 40px;
        padding: 60px 0;
    }

    .product-detail-image {
        max-width: 400px;
        width: 100%;
    }

    .product-detail-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .product-detail-info {
        max-width: 500px;
        width: 100%;
    }

    .product-detail-info h2 {
        font-size: 28px;
        font-weight: bold;
    }

    .product-detail-info .price {
        font-size: 20px;
        color: #EF4444;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .product-detail-info .meta {
        margin-bottom: 15px;
        color: #6B7280;
    }

    .product-detail-info p.description {
        color: #4B5563;
    }
</style>
@endsection

@section('content')
    <div class="container-1920 plr1">
        <div class="product-detail-container">
            <!-- Product Image -->
            <div class="product-detail-image">
                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            <!-- Product Info -->
            <div class="product-detail-info">
                <h2>{{ $product->name }}</h2>
                <p class="description">{{ $product->description ?? 'No description available for this product.' }}</p>
                <div class="price">₹{{ $product->price }}</div>

                <div class="meta">
                    <div><strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}</div>
                    <div><strong>Category:</strong> {{ $product->category->category ?? 'Uncategorized' }}</div>
                </div>

                

                <a href="{{ route('user.product.slider') }}" class="btn btn-outline-secondary mt-4">Back to Products</a>
            </div>
        </div>
    </div>
@endsection