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
                    <form action="#" method="POST">
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
    $(document).ready(function () {
        let selectedCountry = '{{ $identity->country_id ?? '' }}';
        let selectedState   = '{{ $identity->state_id ?? '' }}';
        let selectedCity    = '{{ $identity->city_id ?? '' }}';

        if (selectedCountry) {
            fetchStates(selectedCountry, selectedState);
        }

        if (selectedState) {
            fetchCities(selectedState, selectedCity);
        }

        $('#country').on('change', function () {
            let countryId = $(this).val();
            $('#state').prop('disabled', false);
            fetchStates(countryId, null);
            $('#city').html('<option value="">Select City</option>').prop('disabled', true);
        });

        $('#state').on('change', function () {
            let stateId = $(this).val();
            $('#city').prop('disabled', false);
            fetchCities(stateId, null);
        });

        function fetchStates(countryId, selected = null) {
            $('#state').html('<option>Loading...</option>');
            $.post("{{ route('au.state.all') }}", { country: countryId }, function (res) {
                if (res.status === 'success') {
                    let options = '<option value="">Select State</option>';
                    res.states.forEach(state => {
                        options += `<option value="${state.id}" ${selected == state.id ? 'selected' : ''}>${state.state}</option>`;
                    });
                    $('#state').html(options).prop('disabled', false);
                }
            });
        }

        function fetchCities(stateId, selected = null) {
            $('#city').html('<option>Loading...</option>');
            $.post("{{ route('au.city.all') }}", { state: stateId }, function (res) {
                if (res.status === 'success') {
                    let options = '<option value="">Select City</option>';
                    res.cities.forEach(city => {
                        options += `<option value="${city.id}" ${selected == city.id ? 'selected' : ''}>${city.city}</option>`;
                    });
                    $('#city').html(options).prop('disabled', false);
                }
            });
        }
    });
</script>

{{-- State and city fetch --}}
<script>
    $(function () {
        $('#country, #state, #city').select2({ theme: 'bootstrap4' });

        const csrfToken        = $('meta[name="csrf-token"]').attr('content');
        const $country         = $('#country');
        const $state           = $('#state');
        const $city            = $('#city');
        const deliveryCharges  = @json($deliveryCharges);

        // Fetch states normally…
        $country.on('select2:select', function (e) {
            const countryID = e.params.data.id;
            $state.prop('disabled', true).html('<option>Loading…</option>').trigger('change.select2');
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
                states.forEach(st => $state.append(new Option(st.state, st.id)));
                $state.trigger('change.select2');
            })
            .catch(() => {
                $state.prop('disabled', false)
                    .html('<option disabled>Failed to load states</option>')
                    .trigger('change.select2');
            });
        });

        // When a state is selected, fetch cities AND update delivery charges
        $state.on('select2:select', function () {
            const stateID = $state.val();
            $city.prop('disabled', true).html('<option>Loading…</option>').trigger('change.select2');

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
                cities.forEach(ct => $city.append(new Option(ct.city, ct.id)));
                $city.trigger('change.select2');

                // Now recalc and persist delivery charges
                calculateAndSaveDelivery(stateID);
            })
            .catch(() => {
                $city.prop('disabled', false)
                    .html('<option disabled>Failed to load cities</option>')
                    .trigger('change.select2');
            });
        });

        function calculateAndSaveDelivery(stateID) {
            // Find the delivery rules for the selected state
            const zoneCharge = deliveryCharges.find(c => +c.zone?.state_id === +stateID);

            // Debug: log the zoneCharge object
            console.log('zoneCharge for state', stateID, zoneCharge);

            let footerTotalDelivery = 0;
            let footerGrandTotal    = 0;
            let footerTotalBv       = 0;

            // Loop through each cart row
            $('#order-summary-table tbody tr[data-cart-id]').each(function() {
                const $row      = $(this);
                const cartId    = +$row.data('cart-id');
                const unitPrice = +$row.data('price');
                const bvPerUnit = +$row.data('bv');
                const quantity  = +$row.find('.qty-input').val();

                // Calculate base totals
                const baseTotal = unitPrice * quantity;
                const rowBv     = bvPerUnit * quantity;
                footerTotalBv  += rowBv;

                // Extract size (e.g. "5kg") and parse numeric part
                const sizeLabel = ($row.data('size') || '').toLowerCase();
                let sizeFactor  = 1;
                if (sizeLabel.includes('kg')) {
                sizeFactor = parseFloat(sizeLabel.replace('kg', '').trim()) || 1;
                }

                // Compute delivery charge
                let deliveryCharge = 0;
                if (zoneCharge && zoneCharge.unit_measurement) {
                // Number of 1KG units in the selected size
                const units = Math.ceil(sizeFactor / zoneCharge.unit_measurement);

                // Choose discounted or default per‑kg rate based on min_order
                const perKgRate = baseTotal >= zoneCharge.min_order
                    ? zoneCharge.delivery_charge
                    : zoneCharge.default_delivery_charge;

                deliveryCharge = units * perKgRate;

                console.log(
                    `Size ${sizeFactor}KG → ${units} unit(s) × ₹${perKgRate} = ₹${deliveryCharge}`
                );
                }

                // Update row cells
                $row.find('.delivery-charge-cell').text(`₹${deliveryCharge.toFixed(2)}`);
                $row.find('.product-total-cell').text(`₹${baseTotal.toFixed(2)}`);
                $row.find('.row-grand-total-cell').text(`₹${(baseTotal + deliveryCharge).toFixed(2)}`);
                $row.find('.bv-total-cell').text(rowBv);

                // Persist the delivery charge & BV to backend
                $.post("{{ route('user.cart.update.delivery') }}", {
                _token:           csrfToken,
                cart_id:          cartId,
                delivery_charge:  deliveryCharge,
                total_bv:         rowBv
                });

                // Accumulate footers
                footerTotalDelivery += deliveryCharge;
                footerGrandTotal    += (baseTotal + deliveryCharge);
            });

            // Update footer summary
            $('#total-delivery-charge').text(`₹${footerTotalDelivery.toFixed(2)}`);
            $('#grand-total-amount')  .text(`₹${footerGrandTotal.toFixed(2)}`);
            $('#total-bv-points')     .text(footerTotalBv);
            $('#summary-subtotal').text('₹' + (footerGrandTotal - footerTotalDelivery).toFixed(2));
            $('#summary-total-bv').text(footerTotalBv);
            $('#summary-grand-total').text('₹' + footerGrandTotal.toFixed(2));
            $('#modal_bv_points')     .val(footerTotalBv);
            $('#modal_delivery_charge').val(footerTotalDelivery);
            $('#modal_grand_total')   .val(footerGrandTotal);
            $('#footer-grand-total')  .text(`₹${footerGrandTotal.toFixed(2)}`);
        }

        function recalcFooter() {
  let subtotal = 0,
      totalDel = 0,
      totalBv  = 0;

  $('#order-summary-table tbody tr[data-cart-id]').each(function() {
    const $r     = $(this);
    const price  = parseFloat($r.find('.product-total-cell').text().replace(/[^0-9.]/g, '')) || 0;
    const del    = parseFloat($r.find('.delivery-charge-cell').text().replace(/[^0-9.]/g, ''))  || 0;
    const bv     = parseInt($r.find('.bv-total-cell').text(), 10)                                  || 0;

    subtotal += price;
    totalDel += del;
    totalBv  += bv;
  });

  const grandTotal = subtotal + totalDel;

  // update table footer if you still have one
  $('#footer-subtotal').text('₹' + subtotal.toFixed(2));
  $('#footer-total-bv').text(totalBv);
  $('#footer-grand-total').text('₹' + grandTotal.toFixed(2));

  // ——— and update your summary spans ———
  $('#summary-subtotal').text('₹' + subtotal.toFixed(2));
  $('#summary-total-bv').text(totalBv);
  $('#summary-grand-total').text('₹' + grandTotal.toFixed(2));
}

        $(document).ready(function(){
        // now you can wire up country/state & qty buttons
        $('#state').on('select2:select', e => calculateAndSaveDelivery(e.params.data.id));
        $('.update-qty-btn').on('click', function(){
            /* … after you update the single row … */
            if ($('#state').val()) {
            calculateAndSaveDelivery($('#state').val());
            } else {
            recalcFooter();
            }
        });
        // run one initial recalc so your footer shows something on page‐load
        recalcFooter();
        });

    });
</script>

{{-- Update quantity --}}
{{-- <script>
    $(document).ready(function () {
  $('.update-qty-btn').off('click').on('click', function() {
    const $btn = $(this);
    const cartId   = $btn.data('id');
    const action   = $btn.data('action');
    const $row     = $btn.closest('tr');
    const unitPrice= parseFloat($row.data('price')) || 0; // per-unit incl GST
    const bvPer    = parseInt($row.data('bv')) || 0;

    $.post("{{ route('user.cart.update.quantity') }}", {
      _token: csrfToken,
      id: cartId,
      action: action
    })
    .done(function(res) {
      if (!res.success) {
        return alert(res.message || 'Failed to update quantity');
      }
      // 1. update the input and row data-quantity
      const newQty = res.quantity;
      $row.find('.qty-input').val(newQty);
      $row.attr('data-quantity', newQty);

      // 2. recalc product total and BV for this row
      const newTotal = (unitPrice * newQty).toFixed(2);
      $row.find('.product-total-cell').text('₹' + newTotal);

      const newBvTotal = (bvPer * newQty);
      $row.find('.bv-total-cell').text(newBvTotal);

      // 3. Update the row's grand total (product total + delivery)
      const deliveryCharge = parseFloat(
        $row.find('.delivery-charge-cell').text().replace(/[^0-9.\-]/g,'')
      ) || 0;
      const rowGrandTotal = (parseFloat(newTotal) + deliveryCharge).toFixed(2);
      $row.find('.row-grand-total-cell').text('₹' + rowGrandTotal);

      // 4. Update the footer totals
      recalcFooter();
    })
    .fail(function() {
      alert('Request failed.');
    });
  });
});
</script> --}}
<script>
    $('.update-qty-btn').off('click').on('click', function() {
  const $btn   = $(this);
  const cartId = $btn.data('id');
  const action = $btn.data('action');
  const $row   = $btn.closest('tr');

  $.post("{{ route('user.cart.update.quantity') }}", {
    _token: csrfToken,
    id:     cartId,
    action: action
  })
  .done(function(res) {
    if (!res.success) return alert(res.message || 'Failed to update quantity');

    // Update that row’s UI
    const newQty = res.quantity;
    $row.find('.qty-input').val(newQty);
    $row.attr('data-quantity', newQty);

    const unitPrice = parseFloat($row.data('price')) || 0;
    const bvPer     = parseInt($row.data('bv'))   || 0;
    const newTotal  = (unitPrice * newQty).toFixed(2);
    $row.find('.product-total-cell').text('₹' + newTotal);
    $row.find('.bv-total-cell').text(bvPer * newQty);

    // Delivery didn’t change here, so row‑grand = newTotal + existing delivery
    const deliveryCharge = parseFloat(
      $row.find('.delivery-charge-cell').text().replace(/[^0-9.]/g, '')
    ) || 0;
    $row.find('.row-grand-total-cell')
        .text('₹' + (parseFloat(newTotal) + deliveryCharge).toFixed(2));

    // **NOW** recalc the footer
    recalcFooter();
  });
});
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
<script>
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
</script>

<script>
    $(document).on('click', '#razorpayPayBtn', function () {
  const form = $(this).closest('form')[0];

  const grandTotal   = parseFloat($('#modal_grand_total').val()) || 0;
  const userName     = $('#modal_name').val().trim();
  const email        = $('#modal_email').val().trim();
  const phone        = $('#modal_phone').val().trim();
  const address      = $('#modal_address').val().trim();
  const countryId    = $('#modal_country_id').val();
  const stateId      = $('#modal_state_id').val();
  const cityId       = $('#modal_city_id').val();

  const fixedTotal    = parseFloat(grandTotal.toFixed(2));
  const amountInPaise = Math.round(fixedTotal * 100);

  const options = {
    key: "rzp_test_1DP5mmOlF5G5ag", 
    amount: amountInPaise,
    currency: "INR",
    name: "EasyAdMe",
    description: "Order Payment",
    handler: function (response) {
      $('#modal_transaction_id').val(response.razorpay_payment_id);
      $('#modal_is_paid').val(1);
      form.submit();
    },
    prefill: {
      name: userName,
      email: email,
      contact: phone
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