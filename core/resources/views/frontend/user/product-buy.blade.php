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

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Full Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">{{ __('Country') }}</label>
                            <select name="country" id="country" class="form-control" required>
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">{{ __('State') }}</label>
                            <select name="state" id="state" class="form-control" required>
                                <option value="">{{ __('Select State') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">{{ __('City') }}</label>
                            <input type="text" name="city" id="city" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">{{ __('Place Order') }}</button>
                    </form>
                </div>
            </div>

            <!-- Right: Product Summary -->
            <div class="col-md-6 right">
                <h3 class="mb-4">{{ __('Product Summary') }}</h3>
                @php
                    $imgPath = $product->imageFile->path ?? 'no-image.png';
                    $quantity = old('quantity', 1);
                    $gst = $product->gst ?? 0;
                    $price = $product->distributor_price ?? 0;
                    $weight = $product->weight ?? null;
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
                        @if($weight)
                            <div class="text-muted" style="font-size: 13px;">
                                <strong>Weight:</strong> {{ $weight }} kg
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country');
        const stateSelect   = document.getElementById('state');

        console.log(stateSelect);

        countrySelect.addEventListener('change', function () {
            const countryID = this.value;

            if (!countryID) {
                // Reset if no country selected
                stateSelect.innerHTML = '<option value="">{{ __("Select State") }}</option>';
                stateSelect.disabled  = false;
                return;
            }

            // Show loading state
            stateSelect.innerHTML = '<option selected disabled>{{ __("Loading...") }}</option>';
            stateSelect.disabled  = true;

            fetch("{{ route('user.products.get.states') }}", {  
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ country_id: countryID })
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(states => {
                stateSelect.disabled = false;
                stateSelect.innerHTML = ''; // clear previous options

                if (states.length === 0) {
                    stateSelect.innerHTML = '<option selected disabled>{{ __("No states under selected country") }}</option>';
                } else {
                    stateSelect.innerHTML = '<option value="">{{ __("Select State") }}</option>';
                    states.forEach(st => {
                        const opt = document.createElement('option');
                        opt.value = st.id;
                        opt.text  = st.state;
                        stateSelect.appendChild(opt);
                    });
                }
            })
            .catch(err => {
                console.error('Error fetching states:', err);
                stateSelect.disabled = false;
                stateSelect.innerHTML = '<option selected disabled>{{ __("Failed to load states") }}</option>';
            });
        });
    });
</script>