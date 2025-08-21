@extends('frontend.layout.master')

@section('site-title')
    {{ __('All Products') }}
@endsection

<style>
    .size-btn.selected {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }
</style>

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
                            $sizeIds = explode('|', $product->size_id);
                            $sizePrices = explode('|', $product->size_price);
                        @endphp
                        <a href="{{ route('user.product.details', $product->id) }}">
                            <img src="{{ asset('assets/uploads/media-uploader/' . $imgPath) }}"
                                class="card-img-top"
                                alt="{{ $product->name }}"
                                style="height: 200px; object-fit: contain;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <a href="{{ route('user.product.details', $product->id) }}">
                                <h5 class="card-title">
                                    {{ $product->name }}
                                    @if($product->unit)
                                        <small class="text-muted" style="font-size: 13px;">
                                            ({{ (int) $product->unit_measurement }} {{ $product->unit->name }})
                                        </small>
                                    @endif
                                </h5>
                            </a>

                            @if(!empty($sizeIds[0]))
                                <div class="size-options d-flex flex-wrap gap-2 mb-2" data-base-price="{{ $product->distributor_price }}">
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

                            <p class="card-text text-muted mb-1">
                                <small>DP: ₹<span class="dp-price">{{ $product->distributor_price }}</span> | BV: {{ $product->bv_points ?? 0 }}</small>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
  $(function () {
    const addToCartUrl      = "{{ route('user.add.to.cart') }}";
    const checkCartUrl      = "{{ route('user.check.cart') }}";
    const buyNowRedirectUrl = "{{ route('user.product.buy') }}";

    function showSpinner($btn, text = 'Loading...') {
      $btn.data('original-text', $btn.html());
      $btn.html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>${text}`);
    }
    function restoreButton($btn, text = null) {
      $btn.html(text || $btn.data('original-text'));
    }

    // ───── Size selection ───────────────────────────────────────────────────────
    $(document).on('click', '.size-btn', function () {
      const $btn      = $(this);
      const $group    = $btn.closest('.size-options');
      const basePrice = parseFloat($group.data('base-price')) || 0;
      const extra     = parseFloat($btn.data('size-price')) || 0;

      $group.find('.size-btn').removeClass('selected');
      $btn.addClass('selected');

      $group.closest('.card-body').find('.dp-price')
            .text((basePrice + extra).toFixed(2));
    });

    // ───── Add to Cart ─────────────────────────────────────────────────────────
    $(document).on('click', '.add-to-cart-btn', function (e) {
      e.preventDefault();
      const $btn   = $(this);
      if ($btn.hasClass('processing')) return;

      const $card         = $btn.closest('.card');
      const $sizeGroup    = $card.find('.size-options');
      const $sizeButtons  = $sizeGroup.find('.size-btn');
      const $selectedSize = $sizeGroup.find('.size-btn.selected');

      // ⚠️ If sizes exist, user must pick one
      if ($sizeButtons.length && !$selectedSize.length) {
        toastr.warning('Please select a size before adding to cart.');
        $sizeGroup.addClass('border border-danger rounded p-1');
        return setTimeout(() => $sizeGroup.removeClass('border border-danger p-1'), 1500);
      }

      const payload = {
        product_id : $btn.data('product-id'),
        quantity   : $btn.data('quantity') || 1,
        size_id    : $selectedSize.data('size-id')     || null,
        size_price : $selectedSize.data('size-price')  || 0,
      };

      $btn.addClass('processing').prop('disabled', true);
      showSpinner($btn, 'Adding...');

      fetch(addToCartUrl, {
        method : 'POST',
        headers: {
          'Content-Type' : 'application/json',
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
        },
        body: JSON.stringify(payload)
      })
      .then(r => r.json())
      .then(data => {
        if (data.status === 'success') {
          toastr.success(data.message);
          restoreButton($btn, 'Added');
        } else if (data.status === 'info') {
          toastr.info(data.message);
          restoreButton($btn, 'Already in Cart');
        } else {
          toastr.error(data.message || 'Failed to add product.');
          restoreButton($btn);
        }
        if (data.cart_count !== undefined) {
          $('.cart-count').text(data.cart_count).addClass('pulse');
          setTimeout(() => $('.cart-count').removeClass('pulse'), 600);
        }
      })
      .catch(() => {
        toastr.error('Something went wrong!');
        restoreButton($btn);
      })
      .finally(() => {
        $btn.removeClass('processing').prop('disabled', false);
      });
    });

    // ───── Buy Now ─────────────────────────────────────────────────────────────
    $(document).on('click', '.buy-now-btn', function (e) {
      e.preventDefault();
      const $btn   = $(this);
      if ($btn.hasClass('processing')) return;

      const $card         = $btn.closest('.card');
      const $sizeGroup    = $card.find('.size-options');
      const $sizeButtons  = $sizeGroup.find('.size-btn');
      const $selectedSize = $sizeGroup.find('.size-btn.selected');

      // ⚠️ Enforce size selection if applicable
      if ($sizeButtons.length && !$selectedSize.length) {
        toastr.warning('Please select a size before buying.');
        $sizeGroup.addClass('border border-danger rounded p-1');
        return setTimeout(() => $sizeGroup.removeClass('border border-danger p-1'), 1500);
      }

      const productId = $btn.data('product-id');
      const quantity  = $btn.data('quantity') || 1;
      const payload   = {
        product_id : productId,
        quantity   : quantity,
        size_id    : $selectedSize.data('size-id')    || null,
        size_price : $selectedSize.data('size-price') || 0,
      };

      $btn.addClass('processing').prop('disabled', true);
      showSpinner($btn, 'Buying...');

      // 1) Check if already in cart
      fetch(`${checkCartUrl}?product_id=${productId}`, {
        method : 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      })
      .then(r => r.json())
      .then(data => {
        if (data.in_cart) {
          // go straight to buy
          window.location.href = buyNowRedirectUrl;
        } else {
          // add then buy
          return fetch(addToCartUrl, {
            method : 'POST',
            headers: {
              'Content-Type' : 'application/json',
              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
            },
            body: JSON.stringify(payload)
          })
          .then(r => r.json())
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
        restoreButton($btn, 'Buy Now');
        $btn.removeClass('processing').prop('disabled', false);
      });
    });
  });
</script>
@endsection

