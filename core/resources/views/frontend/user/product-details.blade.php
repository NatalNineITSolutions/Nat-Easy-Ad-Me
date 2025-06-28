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
        font-size: 25px;
        font-weight: 600;
        color: #EF4444;
        margin-bottom: 15px;
    }

    .product-detail-info .meta {
        margin-bottom: 15px;
        color: #6B7280;
    }

    .product-detail-info p.description {
        color: #4B5563;
    }

    .gst {
        font-size: 11px;
        font-weight: 400;
    }
</style>
@endsection

@section('content')
    <div class="container-1920 plr1">
        <div class="product-detail-container">
            <!-- Product Image -->
            <div class="product-detail-image">
                @php
                    $imgPath = $product->imageFile->path ?? 'no-image.png';
                @endphp
                <img src="{{ asset('assets/uploads/media-uploader/' . $imgPath) }}"
                class="card-img-top"
                alt="{{ $product->name }}"
                style="object-fit: contain;">
            </div> 

            <!-- Product Info -->
            <div class="product-detail-info">
                <h2>{{ $product->name }}</h2>
                <p class="description">{{ $product->description ?? 'No description available for this product.' }}</p>
                <div><strong>Category:</strong> {{ $product->category->category ?? 'Uncategorized' }}</div>
                <p class="card-text text-muted">
                    <small>BV Points: {{ $product->bv_points ?? 0 }}</small>
                </p>

                @php
                    $gstPercent = $product->gst ?? 0;
                    $distributorPrice = $product->distributor_price ?? 0;
                    $gstAmount = ($distributorPrice * $gstPercent) / 100;
                    $priceWithGst = $distributorPrice + $gstAmount;
                @endphp

                <div class="text-muted gst mt-3" id="gstAmount" style="font-size: 11px;">
                    <!-- Filled dynamically -->
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="price mb-0" id="totalPrice" style="font-size: 20px;">
                        <!-- Filled dynamically -->
                    </div>
                    <div class="text-muted" style="font-size: 14px;">
                        MRP: <span style="text-decoration: line-through;">₹{{ number_format($product->price, 2) }}</span>
                    </div>
                </div>
                

                <div class="quantity-selector mt-2 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity:</label>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="decreaseQty" class="btn btn-outline-secondary btn-sm h-100 px-3">−</button>
                        
                        <input type="text" id="quantity" name="quantity" value="1" readonly
                            class="form-control text-center h-100" style="width: 60px; min-height: 38px;">
                        
                        <button type="button" id="increaseQty" class="btn btn-outline-secondary btn-sm h-100 px-3">+</button>
                    </div>
                </div>

                <div class="mb-4">
                    <a href="{{ route('user.product.buy', $product->id) }}?quantity=1" 
                    class="btn btn-danger px-4 py-2" id="buyNowBtn">
                        Buy Now
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const decreaseBtn = document.getElementById("decreaseQty");
    const increaseBtn = document.getElementById("increaseQty");
    const quantityInput = document.getElementById("quantity");
    const priceDisplay = document.getElementById("totalPrice");
    const gstDisplay = document.getElementById("gstAmount");
    const buyNowBtn = document.getElementById("buyNowBtn");

    // Set base values from PHP using data attributes
    const distributorPrice = parseFloat({{ $distributorPrice }});
    const gstPercent = parseFloat({{ $gstPercent }});

    function updatePriceAndLink() {
        const qty = parseInt(quantityInput.value);
        const subtotal = distributorPrice * qty;
        const gst = (subtotal * gstPercent) / 100;
        const total = subtotal + gst;

        // Update price display
        gstDisplay.textContent = `GST ( ${gstPercent}% ): ₹${gst.toFixed(2)}`;
        priceDisplay.textContent = `Total: ₹${total.toFixed(2)}`;
        
        // Update Buy Now link with current quantity
        buyNowBtn.href = `{{ route('user.product.buy', $product->id) }}?quantity=${qty}`;
    }

    // Quantity button handlers
    decreaseBtn.addEventListener("click", function () {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
            updatePriceAndLink();
        }
    });

    increaseBtn.addEventListener("click", function () {
        let value = parseInt(quantityInput.value);
        quantityInput.value = value + 1;
        updatePriceAndLink();
    });

    // Initialize
    updatePriceAndLink();
});
</script>