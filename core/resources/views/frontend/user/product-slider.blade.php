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

                                                @if(isset($notVerified) && $notVerified)
                                                    <div class="danger text-center d-flex flex-column align-items-center">
                                                        {{ __('Please verify your identity to see the products') }}
                                                        <a href="{{ route('user.account.settings') }}" class="btn btn-primary mt-3 mx-auto" style="width: 150px;">
                                                            Click here
                                                        </a>
                                                    </div>
                                                @else
                                                
                                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                                        <h3 class="mb-0">{{ __('Products Section') }}</h3>
                                                        <a href="{{ route('user.all.products') }}" class="btn btn-outline-primary btn-sm">
                                                            {{ __('View All') }}
                                                        </a>
                                                    </div>
                                                    <div class="row">
                                                        @forelse($products as $product)
                                                            <div class="col-md-4 col-lg-4 mb-4">
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
                                                                        <p class="card-text text-muted mb-1 d-flex gap-3">
                                                                            <small>DP: ₹{{ $product->distributor_price }}</small>
                                                                            <small>BV: {{ $product->bv_points ?? 0 }}</small>
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

                                                    {{-- 🔻 Pagination Links --}}
                                                    <div class="row">
                                                        <div class="col-12 mt-4">
                                                            <div class="pagination-wrapper d-flex justify-content-center">
                                                                {{ $products->links('pagination::bootstrap-4') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- <script>
        $(function () {
            const addToCartUrl = "{{ route('user.add.to.cart') }}";
            const checkCartUrl = "{{ route('user.check.cart') }}"; 
            const buyNowRedirectUrl = "{{ route('user.product.buy') }}";

            $('.tab-content-wraper').off('click', '.add-to-cart-btn').on('click', '.add-to-cart-btn', function (e) {
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

            // 🔹 Buy Now
            $('.tab-content-wraper').off('click', '.buy-now-btn').on('click', '.buy-now-btn', function (e) {
                e.preventDefault();

                const $btn = $(this);
                if ($btn.hasClass('processing')) return;

                $btn.addClass('processing').prop('disabled', true);

                const productId = $btn.data('product-id');
                const quantity = $btn.data('quantity') || 1;

                // Step 1: Check if product is already in cart
                fetch(checkCartUrl + '?product_id=' + productId, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.in_cart) {
                        // Already in cart — redirect directly
                        window.location.href = buyNowRedirectUrl;
                    } else {
                        // Not in cart — add first
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
    </script> --}}

    <script>
    $(function () {
        const addToCartUrl = "{{ route('user.add.to.cart') }}";
        const checkCartUrl = "{{ route('user.check.cart') }}";
        const buyNowRedirectUrl = "{{ route('user.product.buy') }}";

        function showSpinner($btn, text = 'Loading...') {
            $btn.data('original-text', $btn.html());
            $btn.html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>${text}`);
        }

        function restoreButton($btn) {
            const originalText = $btn.data('original-text');
            if (originalText) $btn.html(originalText);
        }

        $('.tab-content-wraper').off('click', '.add-to-cart-btn').on('click', '.add-to-cart-btn', function (e) {
            e.preventDefault();

            const $btn = $(this);
            if ($btn.hasClass('processing')) return;

            $btn.addClass('processing').prop('disabled', true);
            showSpinner($btn, 'Adding...');

            const productId = $btn.data('product-id');
            const quantity = $btn.data('quantity') || 1;

            fetch(addToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({ product_id: productId, quantity })
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
                restoreButton($btn);
                $btn.removeClass('processing').prop('disabled', false);
            });
        });

        $('.tab-content-wraper').off('click', '.buy-now-btn').on('click', '.buy-now-btn', function (e) {
            e.preventDefault();

            const $btn = $(this);
            if ($btn.hasClass('processing')) return;

            $btn.addClass('processing').prop('disabled', true);
            showSpinner($btn, 'Buying...');

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
                        body: JSON.stringify({ product_id: productId, quantity })
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
                restoreButton($btn);
                $btn.removeClass('processing').prop('disabled', false);
            });
        });
    });
</script>
@endsection
