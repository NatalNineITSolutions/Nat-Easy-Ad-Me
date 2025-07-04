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
                    <small>BV Points: <span id="bvPoints">{{ $product->bv_points ?? 0 }}</span></small>
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

                <div class="mb-4 d-flex gap-3">
                    <a href="#" 
                        class="btn btn-outline-secondary px-4 py-2 w-50 add-to-cart-btn"
                        data-product-id="{{ $product->id }}">
                        Add to Cart
                    </a>

                    <a href="#" 
                        class="btn btn-danger px-4 py-2 w-50 buy-now-btn"
                        data-product-id="{{ $product->id }}">
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
        const bvPointsEl = document.getElementById("bvPoints");

        // Set base values from PHP using data attributes
        const distributorPrice = parseFloat({{ $distributorPrice }});
        const gstPercent = parseFloat({{ $gstPercent }});
        const perUnitBv = parseFloat({{ $product->bv_points ?? 0 }});

        function updatePriceAndGstAndBv() {
            const qty = parseInt(quantityInput.value);
            const subtotal = distributorPrice * qty;
            const gst = (subtotal * gstPercent) / 100;
            const total = subtotal + gst;
            const totalBv = perUnitBv * qty;

            // Update displays
            gstDisplay.textContent = `GST ( ${gstPercent}% ): ₹${gst.toFixed(2)}`;
            priceDisplay.textContent = `Total: ₹${total.toFixed(2)}`;
            
            // Update BV points display
            if (bvPointsEl) {
                bvPointsEl.textContent = totalBv.toFixed(0);
            }
        }

        // Quantity button handlers
        decreaseBtn.addEventListener("click", function () {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
                updatePriceAndGstAndBv();
            }
        });

        increaseBtn.addEventListener("click", function () {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
            updatePriceAndGstAndBv();
        });

        // Initialize
        updatePriceAndGstAndBv();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const addToCartUrl       = "{{ route('user.add.to.cart') }}";
  const checkCartUrl       = "{{ route('user.check.cart') }}";
  const buyNowRedirectUrl  = "{{ route('user.product.buy') }}";
  const quantityInput      = document.getElementById("quantity");
  const bvPointsEl         = document.getElementById("bvPoints");
  const addToCartBtn       = document.querySelector(".add-to-cart-btn");
  const buyNowBtn          = document.querySelector(".buy-now-btn");

  function showSpinner(btn, label = 'Loading...') {
    btn.dataset.originalText = btn.innerHTML;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> ${label}`;
    btn.disabled = true;
  }

  function restoreButton(btn) {
    if (btn.dataset.originalText) {
      btn.innerHTML = btn.dataset.originalText;
    }
    btn.disabled = false;
  }

  // Add to Cart Handler (unchanged)
  addToCartBtn.addEventListener("click", function (e) {
    e.preventDefault();
    const productId = this.dataset.productId;
    const quantity  = parseInt(quantityInput.value) || 1;

    showSpinner(this, 'Adding...');

    fetch(addToCartUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ product_id: productId, quantity })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        toastr.success(data.message);
        if (data.cart_count !== undefined) {
          const cartBadge = document.querySelector('.cart-count');
          if (cartBadge) {
            cartBadge.textContent = data.cart_count;
            cartBadge.classList.add('pulse');
            setTimeout(() => cartBadge.classList.remove('pulse'), 600);
          }
        }
      } else if (data.status === 'info') {
        toastr.info(data.message);
      } else {
        toastr.error(data.message || 'Failed to add product.');
      }
    })
    .catch(() => {
      toastr.error('Something went wrong!');
    })
    .finally(() => {
      restoreButton(this);
    });
  });

  // Buy Now Handler (with BV included)
  buyNowBtn.addEventListener("click", function (e) {
    e.preventDefault();
    const productId = this.dataset.productId;
    const quantity  = parseInt(quantityInput.value) || 1;
    const bvPoints  = parseInt(bvPointsEl.textContent, 10) || 0;

    showSpinner(this, 'Buying...');

    // first check if already in cart
    fetch(`${checkCartUrl}?product_id=${productId}`, {
      method: 'GET',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      }
    })
    .then(res => res.json())
    .then(data => {
      // build the redirect URL, including BV
      const redirectUrl = `${buyNowRedirectUrl}?product_id=${productId}&quantity=${quantity}&bv_points=${bvPoints}`;

      if (data.in_cart) {
        window.location.href = redirectUrl;
      } else {
        // otherwise add to cart, then redirect
        return fetch(addToCartUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify({ product_id: productId, quantity })
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
    .catch(() => {
      toastr.error('Something went wrong during Buy Now!');
    })
    .finally(() => {
      restoreButton(this);
    });
  });
});
</script>
