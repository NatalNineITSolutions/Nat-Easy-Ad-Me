@extends('frontend.layout.master')

@section('site-title')
    {{ __('Product Details') }}
@endsection

@section('style')
<style>
    .size-btn.selected {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }

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
@php
    $gstPercent = $product->gst ?? 0;
    $distributorPrice = $product->distributor_price ?? 0;
@endphp

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
            <p class="description mb-2">{{ $product->description ?? 'No description available for this product.' }}</p>
            {{-- <div><strong>Category:</strong> {{ $product->category->category ?? 'Uncategorized' }}</div> --}}
            

            @php
                $sizeIds = explode('|', $product->size_id);
                $sizePrices = explode('|', $product->size_price);
            @endphp

            @if(!empty($sizeIds[0]))
                <div class="size-options d-flex flex-wrap gap-2 mb-3">
                    @foreach($sizeIds as $index => $sid)
                        @if(isset($sizes[$sid]))
                            <button type="button"
                                    class="btn btn-outline-dark btn-sm size-btn"
                                    data-size-id="{{ $sid }}"
                                    data-size-price="{{ $sizePrices[$index] ?? 0 }}">
                                {{ $sizes[$sid] }}
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="text-muted gst mt-3" id="gstAmount" style="font-size: 11px;"></div>

            <p class="card-text text-muted">
              <small>BV Points: <span id="bvPoints">{{ $product->bv_points ?? 0 }}</span></small>
            </p>

            <div class="d-flex align-items-center gap-3">
                <div class="price mb-0" id="totalPrice" style="font-size: 20px;"></div>
                <div class="text-muted" style="font-size: 14px;">
                    MRP: <span style="text-decoration: line-through;">₹{{ number_format($product->price, 2) }}</span>
                </div>
            </div>


            <div class="quantity-selector mt-2 mb-3">
                <label for="quantity" class="form-label fw-bold">Quantity:</label>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="decreaseQty" class="btn btn-outline-secondary btn-sm h-100 px-3">−</button>
                    <input type="text" id="quantity" name="quantity" value="1" readonly class="form-control text-center h-100" style="width: 60px; min-height: 38px;">
                    <button type="button" id="increaseQty" class="btn btn-outline-secondary btn-sm h-100 px-3">+</button>
                </div>
            </div>

            <div class="mb-4 d-flex gap-3">
                <a href="#" class="btn btn-outline-secondary px-4 py-2 w-50 add-to-cart-btn" data-product-id="{{ $product->id }}">
                    Add to Cart
                </a>
                <a href="#" class="btn btn-danger px-4 py-2 w-50 buy-now-btn" data-product-id="{{ $product->id }}">
                    Buy Now
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  window.addEventListener('load', function () {
    const decreaseBtn = document.getElementById("decreaseQty");
    const increaseBtn = document.getElementById("increaseQty");
    const quantityInput = document.getElementById("quantity");
    const priceDisplay = document.getElementById("totalPrice");
    const gstDisplay = document.getElementById("gstAmount");
    const bvPointsEl = document.getElementById("bvPoints");
    const addToCartBtn = document.querySelector(".add-to-cart-btn");
    const buyNowBtn = document.querySelector(".buy-now-btn");

    const distributorPrice = parseFloat({{ $distributorPrice }});
    const gstPercent = parseFloat({{ $gstPercent }});
    const perUnitBv = parseFloat({{ $product->bv_points ?? 0 }});

    const addToCartUrl       = "{{ route('user.add.to.cart') }}";
    const checkCartUrl       = "{{ route('user.check.cart') }}";
    const buyNowRedirectUrl  = "{{ route('user.product.buy') }}";

    function updatePriceAndGstAndBv() {
        const qty = parseInt(quantityInput.value);
        const selectedSizeBtn = document.querySelector(".size-btn.selected");
        const sizePrice = selectedSizeBtn ? parseFloat(selectedSizeBtn.dataset.sizePrice || 0) : 0;

        const unitPrice = distributorPrice + sizePrice;
        const subtotal = unitPrice * qty;
        const gst = (subtotal * gstPercent) / 100;
        const total = subtotal + gst;
        const totalBv = perUnitBv * qty;

        gstDisplay.textContent = `GST ( ${gstPercent}% ): ₹${gst.toFixed(2)}`;
        priceDisplay.textContent = `Total: ₹${total.toFixed(2)}`;
        if (bvPointsEl) bvPointsEl.textContent = totalBv.toFixed(0);
    }

    function showSpinner(btn, label = 'Loading...') {
        btn.dataset.originalText = btn.innerHTML;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> ${label}`;
        btn.disabled = true;
    }

    function restoreButton(btn) {
        btn.innerHTML = btn.dataset.originalText;
        btn.disabled = false;
    }

    // Prevent multiple bindings
    increaseBtn.onclick = () => {
        let val = parseInt(quantityInput.value);
        quantityInput.value = val + 1;
        updatePriceAndGstAndBv();
    };

    decreaseBtn.onclick = () => {
        let val = parseInt(quantityInput.value);
        if (val > 1) {
            quantityInput.value = val - 1;
            updatePriceAndGstAndBv();
        }
    };

    document.querySelectorAll(".size-btn").forEach(btn => {
        btn.onclick = () => {
            document.querySelectorAll(".size-btn").forEach(b => b.classList.remove("selected"));
            btn.classList.add("selected");
            updatePriceAndGstAndBv();
        };
    });

    addToCartBtn.onclick = function (e) {
        e.preventDefault();

        const selectedSizeBtns = document.querySelectorAll(".size-btn");
        const selectedSizeBtn  = document.querySelector(".size-btn.selected");

        // ❗ Check if size exists but not selected
        if (selectedSizeBtns.length && !selectedSizeBtn) {
            toastr.warning('Please select a size before adding to cart.');
            document.querySelector(".size-options")?.classList.add('border', 'border-danger', 'rounded', 'p-2');
            setTimeout(() => document.querySelector(".size-options")?.classList.remove('border', 'border-danger', 'rounded', 'p-2'), 1500);
            return;
        }

        const productId = this.dataset.productId;
        const quantity  = parseInt(quantityInput.value) || 1;
        const sizeId    = selectedSizeBtn ? selectedSizeBtn.dataset.sizeId : null;
        const sizePrice = selectedSizeBtn ? selectedSizeBtn.dataset.sizePrice : 0;

        showSpinner(this, 'Adding...');

        fetch(addToCartUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ product_id: productId, quantity, size_id: sizeId, size_price: sizePrice })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message);
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge && data.cart_count !== undefined) {
                    cartBadge.textContent = data.cart_count;
                    cartBadge.classList.add('pulse');
                    setTimeout(() => cartBadge.classList.remove('pulse'), 600);
                }
            } else {
                toastr[data.status === 'info' ? 'info' : 'error'](data.message || 'Failed to add product.');
            }
        })
        .catch(() => toastr.error('Something went wrong!'))
        .finally(() => restoreButton(this));
    };

    buyNowBtn.onclick = function (e) {
        e.preventDefault();

        const selectedSizeBtns = document.querySelectorAll(".size-btn");
        const selectedSizeBtn  = document.querySelector(".size-btn.selected");

        // ❗ Check if size exists but not selected
        if (selectedSizeBtns.length && !selectedSizeBtn) {
            toastr.warning('Please select a size before buying.');
            document.querySelector(".size-options")?.classList.add('border', 'border-danger', 'rounded', 'p-2');
            setTimeout(() => document.querySelector(".size-options")?.classList.remove('border', 'border-danger', 'rounded', 'p-2'), 1500);
            return;
        }

        const productId = this.dataset.productId;
        const quantity  = parseInt(quantityInput.value) || 1;
        const bvPoints  = parseInt(bvPointsEl.textContent, 10) || 0;
        const sizeId    = selectedSizeBtn ? selectedSizeBtn.dataset.sizeId : null;
        const sizePrice = selectedSizeBtn ? selectedSizeBtn.dataset.sizePrice : 0;

        showSpinner(this, 'Buying...');

        fetch(`${checkCartUrl}?product_id=${productId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(res => res.json())
        .then(data => {
            const redirectUrl = `${buyNowRedirectUrl}?product_id=${productId}&quantity=${quantity}&bv_points=${bvPoints}&size_id=${sizeId}&size_price=${sizePrice}`;

            if (data.in_cart) {
                window.location.href = redirectUrl;
            } else {
                return fetch(addToCartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ product_id: productId, quantity, size_id: sizeId, size_price: sizePrice })
                })
                .then(res => res.json())
                .then(cartData => {
                    if (cartData.status === 'success' || cartData.status === 'info') {
                        toastr.success(cartData.message || 'Added to cart.');
                        window.location.href = redirectUrl;
                    } else {
                        toastr.error(cartData.message || 'Failed to add to cart.');
                    }
                });
            }
        })
        .catch(() => toastr.error('Something went wrong during Buy Now!'))
        .finally(() => restoreButton(this));
    };

    // Initial calculation
    updatePriceAndGstAndBv();
});
</script>
@endsection
