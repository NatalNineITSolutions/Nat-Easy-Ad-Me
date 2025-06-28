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
                            @php
                                $imgPath = $product->imageFile->path ?? 'no-image.png';
                            @endphp
                            <a href="{{ route('user.product.details', $product->id) }}">
                                <img src="{{ asset('assets/uploads/media-uploader/' . $imgPath) }}"
                                     class="card-img-top"
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: contain;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('user.product.details', $product->id) }}">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                </a>
                                <p class="card-text text-muted">
                                    <small>Distributor Price: ₹{{ $product->distributor_price }}</small>
                                </p>
                                <p class="card-text text-muted mb-1">
                                    <small>BV Points: {{ $product->bv_points ?? 0 }}</small>
                                </p>
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="#" class="btn btn-sm btn-outline-secondary w-50 add-to-cart-btn"
                                       data-product-id="{{ $product->id }}"
                                       data-quantity="1">Add to Cart</a>
                                    <a href="#" class="btn btn-sm btn-primary w-50 buy-now-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-quantity="1">Buy Now</a>
                                </div>
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

@section('scripts')
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(function() {
        const addToCartUrl = "{{ route('user.add.to.cart') }}";
        const checkCartUrl = "{{ route('user.check.cart') }}";
        const buyNowRedirectUrl = "{{ route('user.product.buy') }}";

        // Add to Cart
        $('.container-1920').off('click', '.add-to-cart-btn').on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            const $btn = $(this);
            if ($btn.hasClass('processing')) return;

            $btn.addClass('processing').prop('disabled', true);

            const productId = $btn.data('product-id');
            const quantity = $btn.data('quantity') || 1;

            fetch(addToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);

                    if (data.cart_count !== undefined) {
                        const $cartBadge = $('.cart-count');
                        $cartBadge.text(data.cart_count).addClass('pulse');
                        setTimeout(() => $cartBadge.removeClass('pulse'), 600);
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
                $btn.removeClass('processing').prop('disabled', false);
            });
        });

        // Buy Now
        $('.container-1920').off('click', '.buy-now-btn').on('click', '.buy-now-btn', function(e) {
            e.preventDefault();
            const $btn = $(this);
            if ($btn.hasClass('processing')) return;

            $btn.addClass('processing').prop('disabled', true);

            const productId = $btn.data('product-id');
            const quantity = $btn.data('quantity') || 1;

            fetch(checkCartUrl + '?product_id=' + productId, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.in_cart) {
                    window.location.href = buyNowRedirectUrl;
                } else {
                    return fetch(addToCartUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                    .then(res => res.json())
                    .then(cartData => {
                        if (cartData.status === 'success' || cartData.status === 'info') {
                            toastr.success(cartData.message || 'Added to cart.');
                            window.location.href = buyNowRedirectUrl;
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
                $btn.removeClass('processing').prop('disabled', false);
            });
        });
    });
</script>

@endsection
