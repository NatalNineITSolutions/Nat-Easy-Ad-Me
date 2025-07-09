@extends('frontend.layout.master')

@section('site-title')
    {{ __('Buy Product') }}
@endsection

@section('style')
    <style>

        .section {
            background-color: #F9FAFB;
        }

        .buy-section {
            padding: 30px 0;
        }
        .product-summary img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .left,
        .right {
            background-color: white;
            padding: 15px 25px;
            border-radius: 25px;
        }

        .select2-container .select2-dropdown .select2-results {
        max-height: 200px;
        overflow-y: auto;
        } 

        /* Hover background for Select2 options */
        .select2-container--bootstrap4 .select2-results__option--highlighted {
            background-color: #f0f0f0 !important; /* light gray or use your brand color */
            color: #333; /* optional: dark text for readability */
        }

    </style>
@endsection

@section('content')
<div class="section">
    <div class="container buy-section"> 
        <div class="row">

            <!-- Right: Product Summary -->
            <div class="col-md-12">
                <div class="right">
                    <div class="mt-2">
                        <h5 class="mb-3">{{ __('Order Summary') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="order-summary-table">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product Name</th>
                                        <th>BV</th>
                                        <th>Weight (g)</th>
                                        <th>Size</th>
                                        <th>Price (1 qty)</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Delivery Charge</th>
                                        <th>Total BV</th>
                                        <th>Grand Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $grandTotal = 0;
                                        $index = 1;
                                    @endphp

                                    @foreach($cartItems as $item)
                                        @php
                                            $product      = $item->product;
                                            $quantity     = $item->quantity ?? 1;
                                            $basePrice    = $item->price ?? 0;                // from cart table
                                            $gstPercent   = $product->gst ?? 0;
                                            $gstAmount    = ($basePrice * $gstPercent) / 100;
                                            $priceWithGst = $basePrice + $gstAmount;

                                            $totalPrice = $priceWithGst * $quantity;         // total price including GST
                                            $totalBv    = ($product->bv_points ?? 0) * $quantity; 

                                            $grandTotal += $totalPrice;
                                        @endphp

                                        <tr 
                                            data-product-id="{{ $product->id }}" 
                                            data-cart-id="{{ $item->id }}"         
                                            data-quantity="{{ $quantity }}" 
                                            data-price="{{ $priceWithGst }}"
                                            data-bv="{{ $product->bv_points ?? 0 }}"
                                            data-size="{{ strtolower($item->size->name ?? '') }}"
                                        >
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->bv_points ?? 0 }}</td>
                                            <td>
                                                {{ $product->weight !== null ? (int) $product->weight . ' g' : '—' }}
                                            </td>
                                            <td>{{ $item->size->name ?? '—' }}</td>
                                            <td>
                                                ₹{{ number_format($basePrice, 2) }}<br>
                                                <small>+ ₹{{ number_format($gstAmount, 2) }} GST</small>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-secondary rounded-circle me-1 update-qty-btn"
                                                            data-action="decrease"
                                                            data-id="{{ $item->id }}">−</button>
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center px-1 qty-input"
                                                        value="{{ $quantity }}"
                                                        readonly
                                                        style="width: 40px;"
                                                        data-id="{{ $item->id }}">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-secondary rounded-circle ms-1 update-qty-btn"
                                                            data-action="increase"
                                                            data-id="{{ $item->id }}">+</button>
                                                </div>
                                            </td>
                                            <td class="product-total-cell">₹{{ number_format($totalPrice, 2) }}</td>
                                            <td class="delivery-charge-cell">₹0.00</td>
                                            <td class="bv-total-cell">{{ $totalBv }}</td>
                                            <td class="row-grand-total-cell">₹{{ number_format($totalPrice, 2) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger remove-cart-item" data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- <tr class="fw-bold text-dark">
                                        <td colspan="8" class="text-end">Subtotal:</td>
                                        <td id="footer-total-bv">{{ array_sum(array_map(fn($item) => ($item->product->bv_points ?? 0) * ($item->quantity ?? 1), $cartItems->all())) }}</td>
                                        <td id="footer-subtotal">₹{{ number_format($grandTotal, 2) }}</td>
                                        <td></td>
                                    </tr> --}}
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <p class="mb-1">
                            <strong>{{ __('Subtotal:') }}</strong>
                            <span id="summary-subtotal">₹{{ number_format($grandTotal, 2) }}</span>
                        </p>
                        <p class="mb-1">
                            <strong>{{ __('Delivery Charge:') }}</strong>
                            <span id="summary-delivery-charge">₹0.00</span>
                        </p>
                        <p class="mb-1">
                            <strong>{{ __('Total BV:') }}</strong>
                            <span id="summary-total-bv">{{ $cartItems->sum(fn($item)=>($item->product->bv_points ?? 0) * ($item->quantity ?? 1)) }}</span>
                        </p>
                        <p class="mb-0 fs-5">
                            <strong>{{ __('Grand Total:') }}</strong>
                            <span id="summary-grand-total">₹{{ number_format($grandTotal, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Left: Buy Form -->
            <div class="col-md-12 mt-3">
                <div class="left">
                    <h3 class="mb-4">{{ __('Shipping Information') }}</h3>
                    <form action="{{route ('user.order.store')}}" method="POST">
                        @csrf

                        <input type="hidden" name="quantity" value="{{ $quantity }}">

                         <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        required
                                        value="{{ old('name', $user->username ?? '') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        required
                                        value="{{ old('email', $user->email ?? '') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    class="form-control"
                                    maxlength="10"
                                    pattern="\d{10}"
                                    required
                                    value="{{ old('phone', $user->phone ?? '') }}"
                                >
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea
                                    name="address"
                                    id="address"
                                    rows="3"
                                    class="form-control"
                                    required
                                >{{ old('address', $identity->address ?? '') }}</textarea>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="pincode"
                                    id="pincode"
                                    class="form-control"
                                    maxlength="6"
                                    pattern="\d{6}"
                                    required
                                    value="{{ old('pincode', $identity->zip_code  ?? '') }}"
                                >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Country -->
                            <div class="col-md-4">
                                <label class="form-label">Country<span class="text-danger">*</span></label>
                                <select id="country" name="country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" 
                                            {{ isset($identity) && $identity->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State -->
                            <div class="col-md-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <select id="state" name="state" class="form-control" {{ isset($identity) ? '' : 'disabled' }}>
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <select id="city" name="city" class="form-control" {{ isset($identity) ? '' : 'disabled' }}>
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>

                        @php
                            // fall back to 0 if nothing was passed
                            $initialBv = request()->query('bv_points', 0);
                        @endphp

                        <input 
                            type="hidden" 
                            name="bv_points" 
                            id="modal_bv_points"
                            value="{{ $initialBv }}"  {{-- ← seed it from the URL --}}
                        >

                        <button type="button" id="placeOrderBtn" class="btn btn-primary px-4">
                            {{ __('Place Order') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@include('frontend.user.gateway-markup')

@section('scripts')

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
</script>

<script>
  // 2) Initial country/state/city population
  $(document).ready(function () {
    let selectedCountry = '{{ $identity->country_id ?? '' }}';
    let selectedState   = '{{ $identity->state_id   ?? '' }}';
    let selectedCity    = '{{ $identity->city_id    ?? '' }}';

    if (selectedCountry) {
      fetchStates(selectedCountry, selectedState);
    }
    if (selectedState) {
      fetchCities(selectedState, selectedCity);
    }

    $('#country').on('change', function () {
      const countryId = $(this).val();
      $('#state').prop('disabled', false);
      fetchStates(countryId, null);
      $('#city').html('<option value="">Select City</option>')
                .prop('disabled', true);
    });

    $('#state').on('change', function () {
      const stateId = $(this).val();
      $('#city').prop('disabled', false);
      fetchCities(stateId, null);
    });

    function fetchStates(countryId, selected = null) {
      $('#state').html('<option>Loading...</option>');
      $.post("{{ route('au.state.all') }}",
        { country: countryId },
        function (res) {
          if (res.status === 'success') {
            let options = '<option value="">Select State</option>';
            res.states.forEach(state => {
              options += `<option value="${state.id}"
                             ${selected == state.id ? 'selected' : ''}>
                            ${state.state}
                          </option>`;
            });
            $('#state').html(options).prop('disabled', false);
          }
        }
      );
    }

    function fetchCities(stateId, selected = null) {
      $('#city').html('<option>Loading...</option>');
      $.post("{{ route('au.city.all') }}",
        { state: stateId },
        function (res) {
          if (res.status === 'success') {
            let options = '<option value="">Select City</option>';
            res.cities.forEach(city => {
              options += `<option value="${city.id}"
                             ${selected == city.id ? 'selected' : ''}>
                            ${city.city}
                          </option>`;
            });
            $('#city').html(options).prop('disabled', false);
          }
        }
      );
    }
  });
</script>


{{-- State and city fetch + delivery charges --}}
<script>
  $(function () {
    $('#country, #state, #city').select2({ theme: 'bootstrap4' });

    const $country        = $('#country');
    const $state          = $('#state');
    const $city           = $('#city');
    const deliveryCharges = @json($deliveryCharges);

    // Fetch states via Select2
    $country.on('select2:select', function (e) {
      const countryID = e.params.data.id;
      $state.prop('disabled', true)
            .html('<option>Loading…</option>')
            .trigger('change.select2');
      fetch("{{ route('user.get.states') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ country_id: countryID })
      })
      .then(r => r.json())
      .then(states => {
        $state.prop('disabled', false)
              .empty()
              .append(states.length
                      ? '<option value="">Select State</option>'
                      : '<option disabled>No states</option>');
        states.forEach(st =>
          $state.append(new Option(st.state, st.id))
        );
        $state.trigger('change.select2');
      });

      // clear city
      $city.html('<option value="">Select City</option>')
           .prop('disabled', true)
           .trigger('change.select2');
    });

    // When a state is selected → fetch cities & recalc
    $state.on('select2:select change', function (e) {
      const stateID = e.params?.data?.id || this.value;

      // fetch cities
      $city.prop('disabled', true)
           .html('<option>Loading…</option>')
           .trigger('change.select2');
      fetch("{{ route('user.get.cities') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ state_id: stateID })
      })
      .then(r => r.json())
      .then(cities => {
        $city.prop('disabled', false)
             .empty()
             .append(cities.length
                     ? '<option value="">Select City</option>'
                     : '<option disabled>No cities</option>');
        cities.forEach(ct =>
          $city.append(new Option(ct.city, ct.id))
        );
        $city.trigger('change.select2');
      });

      // recalc delivery now that we have a state
      calculateAndSaveDelivery(stateID);
    });

    function calculateAndSaveDelivery(stateID) {
      const zone = deliveryCharges.find(c => +c.zone?.state_id === +stateID);
      let totalDel = 0, totalBV = 0, grandTot = 0;

      $('#order-summary-table tbody tr[data-cart-id]').each(function () {
        const $row      = $(this);
        const price     = +$row.data('price');
        const bvPerUnit = +$row.data('bv');
        const qty       = +$row.find('.qty-input').val();
        const baseTot   = price * qty;
        const bvTot     = bvPerUnit * qty;
        totalBV       += bvTot;

        // parse "5kg" → 5
        let sizeFactor = 1;
        const sz       = ($row.data('size') || '').toLowerCase();
        if (sz.includes('kg')) sizeFactor = parseFloat(sz) || 1;

        // compute deliveryCharge
        let delCharge = 0;
        if (zone && zone.weight) {
          const unitWeight = parseFloat(zone.weight);
          const minOrder   = parseFloat(zone.min_order);
          const perKgRate  = baseTot >= minOrder
                             ? parseFloat(zone.delivery_charge)
                             : parseFloat(zone.default_delivery_charge);
          const units      = Math.ceil(sizeFactor / unitWeight);
          delCharge = units * perKgRate;
        }

        // write row
        $row.find('.delivery-charge-cell').text(`₹${delCharge.toFixed(2)}`);
        $row.find('.product-total-cell') .text(`₹${baseTot.toFixed(2)}`);
        $row.find('.row-grand-total-cell')
            .text(`₹${(baseTot + delCharge).toFixed(2)}`);

        totalDel += delCharge;
        grandTot  += (baseTot + delCharge);

        // persist
        $.post("{{ route('user.cart.update.delivery') }}", {
          _token:           csrfToken,
          cart_id:          $row.data('cart-id'),
          delivery_charge:  delCharge,
          total_bv:         bvTot
        });
      });

      // update footer
      $('#total-delivery-charge').text(`₹${totalDel.toFixed(2)}`);
      $('#summary-delivery-charge').text(`₹${totalDel.toFixed(2)}`);
      $('#summary-subtotal')    .text(`₹${(grandTot - totalDel).toFixed(2)}`);
      $('#summary-total-bv')    .text(totalBV);
      $('#summary-grand-total') .text(`₹${grandTot.toFixed(2)}`);
    }

    // qty buttons trigger recalculation
    $('.update-qty-btn').off('click').on('click', function () {
      if ($state.val()) calculateAndSaveDelivery($state.val());
      else recalcFooter();
    });

    // initial recalc if pre‑selected
    if ($state.val()) calculateAndSaveDelivery($state.val());
  });
</script>

{{-- Update quantity --}}
<script>
    $(document).off('click', '.update-qty-btn').on('click', '.update-qty-btn', function () {
    const $btn = $(this);
    const cartId = $btn.data('id');
    const action = $btn.data('action');
    const $row = $btn.closest('tr');
    
    // Prevent multiple clicks
    if ($btn.hasClass('processing')) return;
    $btn.addClass('processing').html('<i class="fas fa-spinner fa-spin"></i>');
    
    // Get current quantity from input
    const $qtyInput = $row.find('.qty-input');
    let currentQty = parseInt($qtyInput.val()) || 1;
    
    // Calculate new quantity immediately (before AJAX)
    if (action === 'increase') {
        currentQty++;
    } else if (action === 'decrease' && currentQty > 1) {
        currentQty--;
    }
    
    // Update UI immediately for better responsiveness
    $qtyInput.val(currentQty);
    updateRowTotals($row, currentQty);
    updateFooterTotals();
    
    // Send request to server
    $.ajax({
        url: "{{ route('user.cart.update.quantity') }}",
        method: "POST",
        data: {
            _token: csrfToken,
            id: cartId,
            action: action,
            current_quantity: currentQty
        },
        success: function (res) {
            if (!res.success) {
                showToast('error', res.message || 'Update failed');
                // Revert UI if server update failed
                $qtyInput.val(res.original_quantity || currentQty);
                updateRowTotals($row, res.original_quantity || currentQty);
            }
        },
        error: function () {
            showToast('error', 'Network error. Please try again.');
        },
        complete: function () {
            $btn.removeClass('processing').html(action === 'increase' ? '+' : '−');
        }
    });
});

// Helper function to update row totals
function updateRowTotals($row, quantity) {
    const unitPrice = parseFloat($row.data('price')) || 0;
    const bvPerUnit = parseInt($row.data('bv'), 10) || 0;
    const delivery = parseFloat($row.find('.delivery-charge-cell').text().replace('₹', '')) || 0;
    
    const newTotal = unitPrice * quantity;
    const newBvTotal = bvPerUnit * quantity;
    const newGrandTotal = newTotal + delivery;
    
    $row.find('.product-total-cell').text('₹' + newTotal.toFixed(2));
    $row.find('.bv-total-cell').text(newBvTotal);
    $row.find('.row-grand-total-cell').text('₹' + newGrandTotal.toFixed(2));
    
    // Update data attribute
    $row.attr('data-quantity', quantity);
}

// Update footer totals
function updateFooterTotals() {
    let subtotal = 0;
    let totalBv = 0;
    let grandTotal = 0;
    let totalDelivery = 0;
    
    $('#order-summary-table tbody tr[data-cart-id]').each(function () {
        const $row = $(this);
        subtotal += parseFloat($row.find('.product-total-cell').text().replace('₹', '')) || 0;
        totalBv += parseInt($row.find('.bv-total-cell').text()) || 0;
        totalDelivery += parseFloat($row.find('.delivery-charge-cell').text().replace('₹', '')) || 0;
        grandTotal += parseFloat($row.find('.row-grand-total-cell').text().replace('₹', '')) || 0;
    });
    
    $('#summary-subtotal').text('₹' + subtotal.toFixed(2));
    $('#summary-delivery-charge').text('₹' + totalDelivery.toFixed(2));
    $('#summary-total-bv').text(totalBv);
    $('#summary-grand-total').text('₹' + grandTotal.toFixed(2));
}

// Better notification system
function showToast(type, message) {
    // Replace with your preferred notification system
    const toast = `<div class="alert alert-${type}">${message}</div>`;
    $('.toast-container').append(toast);
    setTimeout(() => $('.alert').remove(), 3000);
}
</script>

{{-- Delete function --}}
<script>
    $(document).ready(function () {
        // Use event delegation with .off() to prevent duplicate bindings
        $(document).off('click', '.remove-cart-item').on('click', '.remove-cart-item', function (e) {
            e.stopImmediatePropagation(); // Prevent other handlers from executing
            
            const itemId = $(this).data('id');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const $button = $(this);

            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return false;
            }

            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ route('user.cart.remove') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: csrfToken,
                    id: itemId
                },
                success: function (response) {
                    if (response.success) {
                        $button.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                            // Update serial numbers
                            $('#order-summary-table tbody tr[data-product-id]').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            // Recalculate if needed
                            const stateID = $('#state').val();
                            if (stateID) calculateDeliveryCharges(stateID);
                        });
                    } else {
                        alert(response.message || 'Failed to remove item.');
                        $button.prop('disabled', false).html('<i class="fas fa-trash-alt"></i>');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Failed to remove item. Please try again.');
                    $button.prop('disabled', false).html('<i class="fas fa-trash-alt"></i>');
                }
            });
            
            return false; // Prevent default action and bubbling
        });
    });
</script>

{{-- Form validation and modal opening --}}
{{-- <script>
    $(function () {
        $('#placeOrderBtn').on('click', function () {
            let isValid = true;
            const $form = $(this).closest('form');

            // Clear previous errors
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            // Validate all required fields
            $form.find('input[required], textarea[required], select.form-control').each(function () {
                const $field = $(this);
                const value = $field.val().trim();

                if (!value) {
                    isValid = false;
                    $field.addClass('is-invalid');
                    $field.after('<div class="invalid-feedback">This field is required.</div>');
                } else if ($field.attr('id') === 'phone') {
                    const phoneRegex = /^\d{10}$/;
                    if (!phoneRegex.test(value)) {
                        isValid = false;
                        $field.addClass('is-invalid');
                        $field.after('<div class="invalid-feedback">Enter a valid 10-digit phone number.</div>');
                    }
                }
            });

            if (!isValid) return;

            // ✅ Extract from DOM — do not re-calculate or redeclare
            const deliveryCharge = parseFloat($('#modal_delivery_charge').val()) || 0;
            const grandTotal     = parseFloat($('#modal_grand_total').val())     || 0;
            const bvPoints       = $('#modal_bv_points').val(); // already set during delivery calc

            // Populate modal fields with form data
            $('#modal_name').val($('#name').val());
            $('#modal_email').val($('#email').val());
            $('#modal_phone').val($('#phone').val());
            $('#modal_address').val($('#address').val());
            $('#modal_pincode').val($('#pincode').val());
            $('#modal_country_id').val($('#country').val());
            $('#modal_state_id').val($('#state').val());
            $('#modal_city_id').val($('#city').val());

            // ✅ Populate hidden modal fields
            $('#modal_delivery_charge').val(deliveryCharge);
            $('#modal_grand_total').val(grandTotal);
            $('#modal_bv_points').val(bvPoints); // already set before, but safe to reaffirm

            // Optional sanity check
            console.log('Submitting to server:', {
                deliveryCharge,
                grandTotal,
                bvPoints
            });

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('orderPaymentModal'));
            modal.show();
        });

        // Live input filtering for phone
        $('#phone').on('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        // Remove error on change/input
        $(document).on('input change', 'input, textarea, select', function () {
            if ($(this).val() !== '') {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
    });
</script> --}}
<script>
    $('#placeOrderBtn').on('click', function (e) {
    e.preventDefault();
    
    // Basic form validation
    let isValid = true;
    $('input[required], select[required], textarea[required]').each(function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
            isValid = false;
        }
    });
    
    if (!isValid) {
        alert('Please fill all required fields');
        return;
    }

    // Calculate totals from the order summary table
    let grandTotal = 0;
    let deliveryCharge = 0;
    let bvPoints = 0;
    
    $('#order-summary-table tbody tr[data-cart-id]').each(function() {
        const $row = $(this);
        
        // Parse row values safely
        const rowTotalText = $row.find('.row-grand-total-cell').text().trim();
        const deliveryText = $row.find('.delivery-charge-cell').text().trim();
        const bvText = $row.find('.bv-total-cell').text().trim();
        
        // Remove currency symbol and commas, then parse
        const rowTotal = parseFloat(rowTotalText.replace(/[^0-9.]/g, '')) || 0;
        const rowDelivery = parseFloat(deliveryText.replace(/[^0-9.]/g, '')) || 0;
        const rowBv = parseInt(bvText.replace(/[^0-9]/g, '')) || 0;
        
        grandTotal += rowTotal;
        deliveryCharge += rowDelivery;
        bvPoints += rowBv;
    });

    // Validate totals
    if (grandTotal <= 0) {
        alert('Invalid order total. Please check your cart items.');
        return;
    }

    // Set the modal values
    $('#modal_delivery_charge').val(deliveryCharge.toFixed(2));
    $('#modal_grand_total').val(grandTotal.toFixed(2));
    $('#modal_bv_points').val(bvPoints);
    
    // Debug the values
    console.log('Order Summary Values:', {
        deliveryCharge: deliveryCharge,
        grandTotal: grandTotal,
        bvPoints: bvPoints
    });
    
    // Show modal
    const modalEl = document.getElementById('orderPaymentModal');
    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else {
        console.error('Payment modal not found');
        alert('Payment system error. Please try again.');
    }
});
</script>

<script>
    $(document).on('click', '#razorpayPayBtn', function() {
    // Get values directly from the hidden inputs
    const grandTotal = parseFloat($('#modal_grand_total').val()) || 0;
    const deliveryCharge = parseFloat($('#modal_delivery_charge').val()) || 0;
    const bvPoints = $('#modal_bv_points').val() || 0;
    
    // Debug the values
    console.log('Payment Values (Before Processing):', {
        grandTotal,
        deliveryCharge,
        bvPoints
    });

    if (grandTotal <= 0) {
        alert('Invalid payment amount');
        return;
    }

    const amountInPaise = Math.round(grandTotal * 100);
    
    const options = {
        key: "rzp_test_1DP5mmOlF5G5ag",
        amount: amountInPaise,
        currency: "INR",
        name: "EasyAdMe",
        description: "Order Payment",
        handler: function(response) {
            $('#modal_transaction_id').val(response.razorpay_payment_id);
            $('#modal_is_paid').val(1);
            $('form').submit();
        },
        prefill: {
            name: $('#modal_name').val(),
            email: $('#modal_email').val(),
            contact: $('#modal_phone').val()
        },
        notes: {
            delivery_charge: deliveryCharge,
            bv_points: bvPoints
        },
        theme: {
            color: "#0d6efd"
        }
    };

    const razorpay = new Razorpay(options);
    razorpay.open();
});
</script>

@endsection