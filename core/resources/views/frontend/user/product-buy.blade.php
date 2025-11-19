@extends('frontend.layout.master')

@section('site-title')
    Buy Product
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
    .left, .right {
        background-color: white;
        padding: 15px 25px;
        border-radius: 25px;
    }
    .select2-container .select2-dropdown .select2-results {
        max-height: 200px;
        overflow-y: auto;
    }
    .select2-container--bootstrap4 .select2-results__option--highlighted {
        background-color: #f0f0f0 !important;
        color: #333;
    }
  select.select2-hidden-accessible {
    display: none !important;
    visibility: hidden !important;
    height: 0 !important;
    width: 0 !important;
    position: absolute !important;
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
                    <h5 class="mb-3">Order Summary</h5>
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
                                    $totalBV = 0;
                                    $subtotal = 0;
                                    $totalDelivery = 0;
                                @endphp
                                @foreach($cartItems as $index => $item)
                                    @php
                                        $product = $item->product;
                                        $qty = $item->quantity;
                                        $basePrice = $item->price;
                                        $gst = $product->gst ?? 0;
                                        $gstAmount = ($basePrice * $gst) / 100;
                                        $priceWithGst = $basePrice + $gstAmount;
                                        $totalPrice = $priceWithGst * $qty;
                                        $bv = $product->bv_points ?? 0;
                                        $totalBV += $bv * $qty;
                                        $subtotal += $totalPrice;
                                        $deliveryCharge = 0;
                                    @endphp

                                    <tr data-product-id="{{ $item->product->id }}"
                                        data-cart-id="{{ $item->id }}"
                                        data-quantity="{{ $item->quantity }}"
                                        data-price="{{ number_format(($item->price + (($item->price * ($item->product->gst ?? 0)) / 100)), 2, '.', '') }}"
                                        data-bv="{{ $item->product->bv_points ?? 0 }}"
                                        data-weight="{{ $item->product->weight ?? 0 }}"
                                        data-size="{{ strtolower($item->size->name ?? '') }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $bv }}</td>
                                        <td>{{ $product->weight ? (int) $product->weight . ' g' : '—' }}</td>
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
                                                    value="{{ $qty }}"
                                                    readonly
                                                    style="width: 40px;">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary rounded-circle ms-1 update-qty-btn"
                                                    data-action="increase"
                                                    data-id="{{ $item->id }}">+</button>
                                            </div>
                                        </td>

                                        @php
                                            $gstAmount = ($item->price * ($item->product->gst ?? 0)) / 100;
                                            $priceWithGst = $item->price + $gstAmount;
                                            $totalPrice = $priceWithGst * $item->quantity;
                                            $bv = $item->product->bv_points ?? 0;
                                            $totalBV = $bv * $item->quantity;
                                            $deliveryCharge = 0; // JS will populate later
                                        @endphp

                                        <td class="product-total-cell">₹{{ number_format($totalPrice, 2) }}</td>
                                        <td class="delivery-charge-cell">₹{{ number_format($deliveryCharge, 2) }}</td>
                                        <td class="bv-total-cell">{{ $bv * $qty }}</td>
                                        <td class="row-grand-total-cell">₹{{ number_format($totalPrice + $deliveryCharge, 2) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger remove-cart-item" data-id="{{ $item->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @php
                        $grandTotal = $subtotal + $totalDelivery;
                    @endphp

                    <div class="mt-3 text-end">
                        <p class="mb-1"><strong>Subtotal:</strong> <span id="summary-subtotal">₹{{ number_format($subtotal, 2) }}</span></p>
                        <p class="mb-1"><strong>Delivery Charge:</strong> <span id="summary-delivery-charge">₹{{ number_format($totalDelivery, 2) }}</span></p>
                        <p class="mb-1"><strong>Total BV:</strong> <span id="summary-total-bv">{{ $totalBV }}</span></p>
                        <p class="mb-0 fs-5"><strong>Grand Total:</strong> <span id="summary-grand-total">₹{{ number_format($grandTotal, 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Left: Shipping Form -->
            <div class="col-md-12 mt-3">
                <div class="left">
                    <h3 class="mb-4">Shipping Information</h3>
                    <form action="{{ route('user.order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="bv_points" value="{{ $totalBV }}">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" id="input_name" name="name" class="form-control" required value="{{ old('name', $user->username ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="input_email"  name="email" class="form-control" required value="{{ old('email', $user->email ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" id="input_phone" name="phone_number" class="form-control" maxlength="10" pattern="\d{10}" required value="{{ old('phone_number', $user->phone ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" required>{{ old('address', $identity->address ?? '') }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                <input type="text" name="pincode" class="form-control" maxlength="6" pattern="\d{6}" required value="{{ old('pincode', $identity->zip_code ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <select id="country_id" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ isset($identity) && $identity->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <select id="state_id" name="state" class="form-control get_country_state">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ (isset($identity) && $identity->state_id == $state->id) ? 'selected' : '' }}>
                                            {{ $state->state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <select id="city_id" name="city" class="form-control get_state_city">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ (isset($identity) && $identity->city_id == $city->id) ? 'selected' : '' }}>
                                            {{ $city->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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
<script>
    window.disableSelect2 = true;
</script>

@include('frontend.user.gateway-markup')

@section('scripts')

{{-- Razorpay Modal Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

{{-- Update Cart quantity and recalculate summary and fetch delivery charge on initial load --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const summarySelectors = {
            subtotal: document.getElementById("summary-subtotal"),
            delivery: document.getElementById("summary-delivery-charge"),
            bv: document.getElementById("summary-total-bv"),
            grand: document.getElementById("summary-grand-total")
        };

        async function getDeliveryCharges(stateId) {
            if (!stateId) return null;
            try {
                const response = await fetch("{{ route('user.get.delivery.charges') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ state_id: stateId })
                });
                return await response.json();
            } catch (error) {
                console.error("Error fetching delivery charges:", error);
                return null;
            }
        }

        async function updateAllDeliveryCharges() {
            const stateId = document.getElementById("state_id").value;
            if (!stateId) return;

            const deliveryData = await getDeliveryCharges(stateId);
            if (!deliveryData?.success) return;

            const charges = deliveryData.charges;
            if (!charges || charges.length === 0) return;

            // Total weight and subtotal (for delivery rule logic)
            let totalWeight = 0, subtotal = 0;
            const rows = document.querySelectorAll("#order-summary-table tbody tr");

            rows.forEach(row => {
                const qty = parseInt(row.querySelector(".qty-input")?.value) || 1;
                const weight = parseFloat(row.dataset.weight) || 0;
                const price = parseFloat(row.dataset.price) || 0;

                totalWeight += weight * qty;
                subtotal += price * qty;
            });

            // Get final flat delivery charge (no multiplication/division)
            charges.sort((a, b) => a.weight - b.weight);
            const applicableRule = charges.find(rule => totalWeight <= rule.weight) || charges[charges.length - 1];
            const deliveryCharge = subtotal >= parseFloat(applicableRule.min_order)
                ? parseFloat(applicableRule.deliver_charge)
                : parseFloat(applicableRule.default_delivery_charge);

            // Apply same delivery charge to all rows without changes
            rows.forEach(row => {
                const qty = parseInt(row.querySelector(".qty-input")?.value) || 1;
                const price = parseFloat(row.dataset.price) || 0;
                const totalPrice = price * qty;

                row.querySelector(".delivery-charge-cell").textContent = `₹${deliveryCharge.toFixed(2)}`;
                row.querySelector(".row-grand-total-cell").textContent = `₹${(totalPrice + deliveryCharge).toFixed(2)}`;
            });

            recalculateSummary();
        }

        function recalculateSummary() {
            let subtotal = 0, totalBV = 0, delivery = 0;

            document.querySelectorAll("#order-summary-table tbody tr").forEach(row => {
                const qty = parseInt(row.querySelector(".qty-input")?.value) || 1;
                const price = parseFloat(row.dataset.price) || 0;
                const bv = parseInt(row.dataset.bv) || 0;
                const del = parseFloat(row.querySelector(".delivery-charge-cell")?.textContent.replace(/[^\d.]/g, '')) || 0;

                subtotal += price * qty;
                totalBV += bv * qty;
                delivery += del;
            });

            const grand = subtotal + delivery;

            summarySelectors.subtotal.textContent = `₹${subtotal.toFixed(2)}`;
            summarySelectors.delivery.textContent = `₹${delivery.toFixed(2)}`;
            summarySelectors.bv.textContent = totalBV;
            summarySelectors.grand.textContent = `₹${grand.toFixed(2)}`;
        }

        document.querySelectorAll(".update-qty-btn").forEach(button => {
            button.addEventListener("click", async function () {
                const $btn = this;
                const action = $btn.dataset.action;
                const cartId = $btn.dataset.id;
                const row = $btn.closest("tr");

                if (!action || !cartId || $btn.disabled) return;

                const qtyInput = row.querySelector(".qty-input");
                let currentQty = parseInt(qtyInput.value);

                if (action === "decrease" && currentQty <= 1) return;

                $btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                $btn.disabled = true;

                try {
                    const res = await fetch("{{ route('user.cart.update.quantity') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id: cartId, action })
                    });

                    const data = await res.json();
                    if (data.success) {
                        const newQty = data.quantity;
                        qtyInput.value = newQty;

                        const price = parseFloat(row.dataset.price);
                        const totalPrice = (price * newQty).toFixed(2);

                        row.querySelector(".product-total-cell").textContent = `₹${totalPrice}`;
                        row.querySelector(".bv-total-cell").textContent = data.total_bv;

                        // Only update total and summary — delivery charge stays the same
                        recalculateSummary();
                    } else {
                        alert("Update failed.");
                    }
                } catch (err) {
                    console.error(err);
                    alert("Error updating quantity.");
                } finally {
                    $btn.innerHTML = action === "increase" ? "+" : "-";
                    $btn.disabled = false;
                }
            });
        });

        document.getElementById("state_id")?.addEventListener("change", updateAllDeliveryCharges);

        updateAllDeliveryCharges(); // Initial load
    });
</script>

{{-- Delete from cart and recalculate summary --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const summarySelectors = {
            subtotal: document.getElementById("summary-subtotal"),
            delivery: document.getElementById("summary-delivery-charge"),
            bv: document.getElementById("summary-total-bv"),
            grand: document.getElementById("summary-grand-total")
        };

        // Handle delete icon click
        document.querySelectorAll(".remove-cart-item").forEach(button => {
            button.addEventListener("click", async function () {
                const $btn = this;
                const cartId = $btn.dataset.id;
                const row = $btn.closest("tr");

                if (!cartId || !row) return;

                const originalHTML = $btn.innerHTML;
                $btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                $btn.disabled = true;

                try {
                    const res = await fetch("{{ route('user.cart.remove') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ id: cartId })
                    });

                    const data = await res.json();
                    if (data.success) {
                        row.remove();
                        recalculateSummary();

                        // Optional: If cart is empty, show empty row
                        const remainingRows = document.querySelectorAll("#order-summary-table tbody tr").length;
                        if (remainingRows === 0) {
                            const tbody = document.querySelector("#order-summary-table tbody");
                            tbody.innerHTML = `<tr><td colspan="12" class="text-center text-muted">Your cart is now empty.</td></tr>`;
                        }
                    } else {
                        $btn.innerHTML = originalHTML;
                        $btn.disabled = false;
                    }
                } catch (err) {
                    console.error("Delete failed:", err);
                    $btn.innerHTML = originalHTML;
                    $btn.disabled = false;
                }
            });
        });

        function recalculateSummary() {
            let subtotal = 0, totalBV = 0, delivery = 0;

            document.querySelectorAll("#order-summary-table tbody tr").forEach(row => {
                const qty = parseInt(row.querySelector(".qty-input")?.value) || 1;
                const price = parseFloat(row.dataset.price) || 0;
                const bv = parseInt(row.dataset.bv) || 0;
                const del = parseFloat(row.querySelector(".delivery-charge-cell")?.textContent.replace(/[^\d.]/g, '')) || 0;

                subtotal += price * qty;
                totalBV += bv * qty;
                delivery += del;
            });

            const grand = subtotal + delivery;

            summarySelectors.subtotal.textContent = `₹${subtotal.toFixed(2)}`;
            summarySelectors.delivery.textContent = `₹${delivery.toFixed(2)}`;
            summarySelectors.bv.textContent = totalBV;
            summarySelectors.grand.textContent = `₹${grand.toFixed(2)}`;
        }
    });
</script>

{{-- Fetch Country, state and city --}}

{{-- Open Payment gateways modal --}}
<script>
    $('#placeOrderBtn').on('click', function (e) {
        e.preventDefault();

        const name = $('#input_name').val();
        const email = $('#input_email').val();
        const phone = $('#input_phone').val();
        const address = $('textarea[name="address"]').val();
        const country = $('#country_id').val();
        const state = $('#state_id').val();
        const city = $('#city_id').val();

        // Debug print
        console.log('[placeOrderBtn] modal values:', 'name=', name, 'email=', email, 'phone=', phone,
                    'address=', address, 'country_id=', country, 'state_id=', state, 'city_id=', city);

        if (!name || !email || !phone) {
            alert('Please fill out name, email, and phone before continuing.');
            return;
        }

        $('#modal_name').val(name);
        $('#modal_email').val(email);
        $('#modal_phone').val(phone);
        $('#modal_address').val(address);
        $('#modal_country_id').val(country);
        $('#modal_state_id').val(state);
        $('#modal_city_id').val(city);

        const deliveryCharge = $('#summary-delivery-charge').text().replace(/[^0-9.]/g, '');
        const grandTotal = $('#summary-grand-total').text().replace(/[^0-9.]/g, '');
        const bvPoints = $('#summary-total-bv').text();

        $('#modal_delivery_charge').val(deliveryCharge);
        $('#modal_grand_total').val(grandTotal);
        $('#modal_bv_points').val(bvPoints);

        const modalEl = document.getElementById('orderPaymentModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

</script>

{{-- Open Razorpay Modal --}}
<script>
  $(document).on('click', '#razorpayPayBtn', function () {
    const grandTotal     = parseFloat($('#modal_grand_total').val()) || 0;
    const amountInPaise  = Math.round(grandTotal * 100);

    if (grandTotal <= 0 || amountInPaise <= 0) {
      alert("Invalid payment amount");
      return;
    }

    const options = {
      key: "rzp_test_1DP5mmOlF5G5ag",
      amount: amountInPaise,
      currency: "INR",
      name: "EasyAdMe",
      description: "Order Payment",

      handler: function (response) {
        console.log('[Razorpay handler] res =', response);

        // 🔥 CLEAN PHONE NUMBER (remove +, -, spaces, and keep last 10 digits)
        const cleanPhone = $('input[name="phone_number"]')
            .val()
            .replace(/\D/g, '')   // remove all non-digits
            .slice(-10);          // keep last 10 digits only

        // ✅ Fill hidden form fields
        $('#modal_transaction_id').val(response.razorpay_payment_id);
        $('#modal_is_paid').val(1);

        $('#modal_name').val($('input[name="name"]').val());
        $('#modal_email').val($('input[name="email"]').val());
        $('#modal_phone').val(cleanPhone);
        $('#modal_address').val($('textarea[name="address"]').val());
        $('#modal_country_id').val($('#country_id').val());
        $('#modal_state_id').val($('#state_id').val());
        $('#modal_city_id').val($('#city_id').val());

        // Check required fields
        const allFieldsFilled =
          $('#modal_name').val() &&
          $('#modal_email').val() &&
          $('#modal_phone').val() &&
          $('#modal_address').val() &&
          $('#modal_country_id').val() &&
          $('#modal_state_id').val() &&
          $('#modal_city_id').val();

        if (!allFieldsFilled) {
          alert("Please ensure all fields are filled correctly before proceeding.");
          return;
        }

        console.log('[Razorpay handler] Submitting form...');
        document.querySelector('#orderPaymentModal form').submit();
      },

      prefill: {
        name: $('input[name="name"]').val(),
        email: $('input[name="email"]').val(),

        // 🔥 Prefill with clean phone too
        contact: $('input[name="phone_number"]')
            .val()
            .replace(/\D/g, '')
            .slice(-10),
      },

      notes: {
        delivery_charge: $('#modal_delivery_charge').val(),
        bv_points: $('#modal_bv_points').val()
      },

      theme: { color: "#0d6efd" }
    };

    const razorpay = new Razorpay(options);
    razorpay.open();
  });
</script>

<script>
$(document).ready(function () {

    // 1️⃣ Remove any existing Select2 containers (from earlier scripts)
    $('#country_id').next('.select2-container').remove();
    $('#state_id').next('.select2-container').remove();
    $('#city_id').next('.select2-container').remove();

    // 2️⃣ Destroy any existing Select2 instance safely (if already bound)
    if ($('#country_id').data('select2')) {
        $('#country_id').select2('destroy');
    }
    if ($('#state_id').data('select2')) {
        $('#state_id').select2('destroy');
    }
    if ($('#city_id').data('select2')) {
        $('#city_id').select2('destroy');
    }

    // 3️⃣ Initialize Select2 ONCE, clean and controlled
    $('#country_id').select2({ width: '100%' });
    $('#state_id').select2({ width: '100%' });
    $('#city_id').select2({ width: '100%' });

    // 4️⃣ Your existing change/ AJAX logic stays the same
    $(document).on('select2:select', '#country_id', function () {
        $(this).trigger('change');
    });
    $(document).on('select2:select', '#state_id', function () {
        $(this).trigger('change');
    });
    $(document).on('select2:select', '#city_id', function () {
        $(this).trigger('change');
    });

    $(document).on('change', '#country_id', function () {
        console.log("COUNTRY CHANGED:", $(this).val());

        const id = $(this).val();
        $('#state_id').prop('disabled', true).html('<option>Loading...</option>');
        $('#city_id').prop('disabled', true).html('<option>Select City</option>');

        $.post('{{ route("user.get.states") }}', {country_id: id}, function (states) {
            let html = '<option value="">Select State</option>';
            states.forEach(s => html += `<option value="${s.id}">${s.state}</option>`);
            $('#state_id').html(html).prop('disabled', false).trigger('change.select2');
        });
    });

    $(document).on('change', '#state_id', function () {
        console.log("STATE CHANGED:", $(this).val());

        const id = $(this).val();
        $('#city_id').prop('disabled', true).html('<option>Loading...</option>');

        $.post('{{ route("user.get.cities") }}', {state_id: id}, function (cities) {
            let html = '<option value="">Select City</option>';
            cities.forEach(c => html += `<option value="${c.id}">${c.city}</option>`);
            $('#city_id').html(html).prop('disabled', false).trigger('change.select2');
        });

        updateDeliveryCharges(id);
    });

});
</script>


@endsection