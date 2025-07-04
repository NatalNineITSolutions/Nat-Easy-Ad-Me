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
                                        <th>BV Points</th>
                                        <th>Weight</th>
                                        <th>Price (1 qty)</th>
                                        <th>Quantity</th>
                                        <th>Delivery Charge</th> <!-- Individual delivery charge column -->
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php
                                        $grandTotal = 0;
                                        $totalDelivery = 0;
                                        $index = 1;
                                    @endphp

                                    @foreach($cartItems as $item)
                                        @php
                                            $product = $item->product;
                                            $quantity = $item->quantity ?? 1;
                                            $price = $product->distributor_price ?? 0;
                                            $gst = $product->gst ?? 0;
                                            $weight = $product->weight ?? 0;
                                            $bv = $product->bv_points ?? 0;

                                            $gstAmount = ($price * $gst) / 100;
                                            $totalPerItem = $price + $gstAmount;
                                            $totalWeight = $weight * $quantity;
                                            $finalTotal = $totalPerItem * $quantity;
                                            
                                            // Initialize delivery charge for each product
                                            $deliveryCharge = 0;
                                            $grandTotal += $finalTotal;
                                        @endphp
                                        <tr 
                                            data-product-id="{{ $product->id }}" 
                                            data-cart-id="{{ $item->id }}"         
                                            data-weight="{{ $weight }}" 
                                            data-quantity="{{ $quantity }}" 
                                            data-price="{{ $totalPerItem }}"
                                            data-bv="{{ $product->bv_points ?? 0 }}"
                                        >
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $bv }}</td>
                                            <td>
                                                @if($weight > 0)
                                                    {{ rtrim(rtrim(number_format($weight, 2, '.', ''), '0'), '.') }}kg × {{ $quantity }} =
                                                    {{ rtrim(rtrim(number_format($totalWeight, 2, '.', ''), '0'), '.') }}kg
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($totalPerItem, 2) }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle me-1 update-qty-btn" data-action="decrease" data-id="{{ $item->id }}">−</button>
                                                    <input type="text" class="form-control form-control-sm text-center px-1 qty-input" value="{{ $quantity }}" readonly style="width: 40px;" data-id="{{ $item->id }}">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle ms-1 update-qty-btn" data-action="increase" data-id="{{ $item->id }}">+</button>
                                                </div>
                                            </td>
                                            <td class="delivery-charge-cell">₹0.00</td> <!-- Will be updated via JavaScript -->
                                            <td class="product-total-cell">₹{{ number_format($finalTotal, 2) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger remove-cart-item" data-id="{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr class="fw-bold text-dark">
                                        <td colspan="6" class="text-end">Subtotal:</td>
                                        <td id="total-delivery-charge">₹0.00</td>
                                        <td id="grand-total-amount">₹{{ number_format($grandTotal, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- State -->
                            <div class="col-md-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <select id="state" name="state" class="form-control" disabled>
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <!-- City -->
                            <div class="col-md-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <select id="city" name="city" class="form-control" disabled>
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
            const zoneCharge = deliveryCharges.find(c =>
                parseInt(c.zone?.state_id) === parseInt(stateID)
            ) || {};

            let footerTotalDelivery = 0;
            let footerGrandTotal    = 0;
            let footerTotalBv       = 0;    // ← initialize BV accumulator

            $('#order-summary-table tbody tr[data-cart-id]').each(function() {
                const $row             = $(this);
                const cartId           = $row.data('cart-id');
                const weight           = parseFloat($row.data('weight'))    || 0;
                const quantity         = parseInt($row.data('quantity'))    || 1;
                const unitPrice        = parseFloat($row.data('price'))     || 0;
                const productBaseTotal = unitPrice * quantity;
                const totalWeightG     = weight * quantity * 1000;
                const perUnitBv        = parseFloat($row.data('bv'))        || 0;
                const rowBv            = perUnitBv * quantity;

                // Accumulate BV
                footerTotalBv += rowBv;

                // delivery charge per‑row
                let deliveryCharge = 0;
                if (zoneCharge.weight_in_grams) {
                    const perUnitCharge = (productBaseTotal >= zoneCharge.min_order)
                                        ? zoneCharge.delivery_charge
                                        : zoneCharge.default_delivery_charge;
                    const units         = Math.ceil(totalWeightG / zoneCharge.weight_in_grams);
                    deliveryCharge      = units * perUnitCharge;
                }

                // update this row’s UI
                $row.find('.delivery-charge-cell')
                    .text(`₹${deliveryCharge.toFixed(2)}`);
                const rowTotal = productBaseTotal + deliveryCharge;
                $row.find('.product-total-cell')
                    .text(`₹${rowTotal.toFixed(2)}`);

                // persist to backend
                $.ajax({
                    url: "{{ route('user.cart.update.delivery') }}",
                    method: "POST",
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        cart_id:         cartId,
                        delivery_charge: deliveryCharge
                    }
                });

                // accumulate footer totals
                footerTotalDelivery += deliveryCharge;
                footerGrandTotal    += rowTotal;
            });

            // refresh footer sums
            $('#total-delivery-charge').text(`₹${footerTotalDelivery.toFixed(2)}`);
            $('#grand-total-amount')  .text(`₹${footerGrandTotal   .toFixed(2)}`);

            // BV into visible or hidden fields
            $('#total-bv-points')     .text(footerTotalBv.toFixed(0));   // if you have a visible BV footer cell
            $('#modal_bv_points')     .val(footerTotalBv.toFixed(0));   // hidden input for form

            // keep the other hidden totals in sync
            $('#modal_delivery_charge').val(footerTotalDelivery.toFixed(2));
            $('#modal_grand_total')   .val(footerGrandTotal   .toFixed(2));
        }

    });
</script>

{{-- Update quantity --}}
<script>
    $(document).ready(function () {
        // Always unbind previous click events before binding new ones
        $('.update-qty-btn').off('click').on('click', function () {
            const $btn = $(this);
            const itemId = $btn.data('id');
            const action = $btn.data('action');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('user.cart.update.quantity') }}",
                method: "POST",
                data: {
                    _token: csrfToken,
                    id: itemId,
                    action: action
                },
                success: function (response) {
                    if (response.success) {
                        // Update only the quantity field
                        $('.qty-input[data-id="' + itemId + '"]').val(response.quantity);

                        // Soft reload: update weight, price, delivery, total dynamically
                        location.reload(); // OR use your delivery calculation method
                    } else {
                        alert('Something went wrong.');
                    }
                },
                error: function () {
                    alert('Failed to update quantity.');
                }
            });
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
            const deliveryCharge = $('#total-delivery-charge').text().replace(/[₹,]/g, '') || 0;
            const grandTotal     = $('#grand-total-amount').text().replace(/[₹,]/g, '') || 0;
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
    document.addEventListener('DOMContentLoaded', function () {
        const payBtn = document.querySelector('#orderPaymentModal button[type="submit"]');

        payBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');

            const grandTotal = parseFloat(document.getElementById('modal_grand_total').value) || 0;
            const userName = document.getElementById('modal_name').value;
            const email = document.getElementById('modal_email').value;
            const phone = document.getElementById('modal_phone').value;

            if (!grandTotal || !userName || !email || !phone) {
                alert('Missing order information.');
                return;
            }

            const fixedTotal    = parseFloat(grandTotal.toFixed(2));   // e.g. "268.80"
            const amountInPaise = Math.round(fixedTotal * 100);

            const options = {
                key: "rzp_test_1DP5mmOlF5G5ag", 
                amount: amountInPaise,
                currency: "INR",
                name: "EasyAdMe",
                description: "Order Payment",
                handler: function (response) {
                    // On successful payment
                    document.getElementById('modal_transaction_id').value = response.razorpay_payment_id;
                    document.getElementById('modal_is_paid').value = 1;
                    form.submit(); // Submit the form to backend (Laravel)
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
    });
</script>

@endsection