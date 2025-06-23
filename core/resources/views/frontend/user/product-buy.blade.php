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
            <!-- Left: Buy Form -->
            <div class="col-md-6">
                <div class="left">
                    <h3 class="mb-4">{{ __('Shipping Information') }}</h3>
                    <form action="#" method="POST">
                        @csrf

                        <input type="hidden" name="quantity" value="{{ $quantity }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                            </div>  

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}<span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}<span class="text-danger">*</span></label>
                            <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
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

                        <div class="mb-3">
                            <label for="pincode" class="form-label">{{ __('Pincode') }}<span class="text-danger">*</span></label>
                            <input type="text" name="pincode" id="pincode" class="form-control" maxlength="6" pattern="\d{6}" required>
                        </div>

                        <button type="button" id="placeOrderBtn" class="btn btn-primary px-4">
                            {{ __('Place Order') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Product Summary -->
            <div class="col-md-6 right">
                <h3 class="mb-4">{{ __('Product Summary') }}</h3>
                @php
                    $imgPath = $product->imageFile->path ?? 'no-image.png';
                    $quantity = request()->query('quantity', 1); // Get from query parameter
                    $gst = $product->gst ?? 0;
                    $price = $product->distributor_price ?? 0;
                    $weight = $product->weight ?? 0;
                    $totalWeight = $weight * $quantity;
                    $gstAmount = ($price * $gst) / 100;
                    $totalPerItem = $price + $gstAmount;
                    $finalTotal = $totalPerItem * $quantity;
                @endphp

                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('assets/uploads/media-uploader/' . $imgPath) }}"
                        alt="{{ $product->name }}"
                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $product->name }} × {{ $quantity }}</strong>
                            <strong>₹{{ number_format($finalTotal, 2) }}</strong>
                        </div>
                        <div class="text-muted" style="font-size: 14px;">
                            (₹{{ number_format($totalPerItem, 2) }} per item incl. GST)
                        </div>
                        @if($weight > 0)
                            <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                                <span><strong>Weight:</strong> {{ $weight }}kg × {{ $quantity }}</span>
                                <span><strong>{{ number_format($totalWeight, 2) }}kg</strong></span>
                            </div>
                        @endif
                        <!-- In your product summary section -->
                        <div id="delivery-charge-container" class="mt-2" style="display: none;">
                            <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                                <span><strong>Delivery Charge:</strong></span>
                                <span><strong id="delivery-charge-amount"></strong></span>
                            </div>
                            <div id="delivery-calculation" class="text-muted" style="font-size: 11px; display: none;">
                                <span id="calculation-text"></span>
                            </div>
                        </div>
                        <div id="grand-total-container" class="d-flex justify-content-between fw-bold text-dark mt-2" style="font-size: 14px; display: none;">
                            <span><strong>Grand Total:</strong></span>
                            <span><strong id="grand-total-amount"></strong></span>
                        </div>
                    </div>
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
    $(function(){
        $('#country, #state, #city').select2({ theme: 'bootstrap4' });

        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const $country  = $('#country');
        const $state    = $('#state');
        const $city     = $('#city');

        const deliveryCharges = @json($deliveryCharges);
        const productWeight = {{ $product->weight ?? 0 }};
        const quantity = {{ $quantity }};
        const totalWeightInGrams = productWeight * quantity * 1000;
        const productTotal = {{ $finalTotal }};

        // Initialize with product total as grand total
        $('#grand-total-amount').text(`₹${productTotal.toFixed(2)}`);
        $('#grand-total-container').show();
        $('#delivery-charge-amount').text('₹0.00');
        $('#delivery-charge-container').show();

        // Fetch states
        $country.on('select2:select', function(e){
            const countryID = e.params.data.id;

            $state.prop('disabled', true)
                .html('<option selected disabled>Loading…</option>')
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
                        : '<option selected disabled>No states available</option>');

                states.forEach(st => $state.append(new Option(st.state, st.id)));
                $state.trigger('change.select2');
            })
            .catch(() => {
                $state.prop('disabled', false)
                    .html('<option selected disabled>Failed to load states</option>')
                    .trigger('change.select2');
            });
        });

        // Fetch cities + Calculate delivery & grand total
        $state.on('select2:select', function (e) {
            const stateID = $state.val();

            $city.prop('disabled', true)
                .html('<option selected disabled>Loading…</option>')
                .trigger('change.select2');

            // Fetch cities
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
                        : '<option selected disabled>No cities available</option>');

                cities.forEach(city => $city.append(new Option(city.city, city.id)));
                $city.trigger('change.select2');

                // === DELIVERY & GRAND TOTAL ===
                const charge = deliveryCharges.find(c => parseInt(c.zone?.state_id) === parseInt(stateID));
                let deliveryCharge = 0;
                let calculationText = '';
                let perUnitCharge = 0;
                let perUnitGrams = 0;

                if (charge && charge.weight_in_grams) {
                    perUnitGrams = charge.weight_in_grams;
                    
                    // Check if product total meets minimum order for discounted rate
                    if (productTotal >= charge.min_order) {
                        perUnitCharge = charge.delivery_charge; // ₹25 for orders ₹2500+
                        calculationText = `Discounted rate applied (order ≥ ₹${charge.min_order})`;
                    } else {
                        perUnitCharge = charge.default_delivery_charge; // ₹38 for orders < ₹2500
                        calculationText = `Standard rate (order < ₹${charge.min_order})`;
                    }

                    const unitCount = Math.ceil(totalWeightInGrams / perUnitGrams);
                    deliveryCharge = unitCount * perUnitCharge;
                    
                    // Add calculation details
                    calculationText += `<br>${totalWeightInGrams}g / ${perUnitGrams}g = ${unitCount} units × ₹${perUnitCharge} = ₹${deliveryCharge.toFixed(2)}`;
                } else {
                    calculationText = "Free delivery";
                    deliveryCharge = 0;
                }

                const grandTotal = productTotal + deliveryCharge;

                $('#delivery-charge-amount').text(`₹${deliveryCharge.toFixed(2)}`);
                $('#calculation-text').html(calculationText);
                $('#delivery-calculation').show();
                $('#delivery-charge-container').show();

                $('#grand-total-amount').text(`₹${grandTotal.toFixed(2)}`);
                $('#grand-total-container').show();
            })
            .catch(() => {
                $city.prop('disabled', false)
                    .html('<option selected disabled>Failed to load cities</option>')
                    .trigger('change.select2');
            });
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

            if (isValid) {
                // Populate modal fields with form data
                $('#modal_name').val($('#name').val());
                $('#modal_email').val($('#email').val());
                $('#modal_phone').val($('#phone').val());
                $('#modal_address').val($('#address').val());
                $('#modal_pincode').val($('#pincode').val());
                $('#modal_country_id').val($('#country').val());
                $('#modal_state_id').val($('#state').val());
                $('#modal_city_id').val($('#city').val());

                // VERY IMPORTANT: populate grand total and delivery charge too
                const deliveryCharge = $('#delivery-charge-amount').text().replace(/[₹,]/g, '') || 0;
                const grandTotal     = $('#grand-total-amount').text().replace(/[₹,]/g, '') || 0;

                $('#modal_delivery_charge').val(deliveryCharge);
                $('#modal_grand_total').val(grandTotal);

                // Now show the Razorpay modal
                const modal = new bootstrap.Modal(document.getElementById('orderPaymentModal'));
                modal.show();
            }

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

        const options = {
            key: "rzp_test_1DP5mmOlF5G5ag", 
            amount: Math.round(grandTotal * 100), // Razorpay expects amount in paise
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