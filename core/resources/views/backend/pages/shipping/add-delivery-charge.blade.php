@extends('backend.admin-master')

@section('site-title', isset($deliveryCharge) ? __('Edit Delivery Charges') : __('Add Delivery Charges'))

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ isset($deliveryCharge) ? __('Edit Delivery Charges') : __('Add Delivery Charges') }}</h4>

    <form action="{{ isset($deliveryCharge) ? route('admin.shipping.update.delivery.charge', $deliveryCharge->id) : route('admin.shipping.store.delivery.charge') }}" method="POST">
        @csrf
        @if(isset($deliveryCharge))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">{{ __('Select Zone') }}</label>

            @if(isset($deliveryCharge))
                {{-- Editing: show disabled dropdown for display + hidden real input --}}
                <select name="zone_id_disabled" class="form-control" disabled>
                    <option value="">{{ __('Select a Zone') }}</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ $deliveryCharge->zone_id == $zone->id ? 'selected' : '' }}>
                            {{ $zone->zone_name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="zone_id" value="{{ $deliveryCharge->zone_id }}">
            @else
                {{-- Creating: normal, enabled dropdown --}}
                <select name="zone_id" class="form-control @error('zone_id') is-invalid @enderror" required>
                    <option value="">{{ __('Select a Zone') }}</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->zone_name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Weight (in grams)') }}</label>
            <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $deliveryCharge->weight ?? '') }}" required>
            <small class="text-muted">{{ __('Enter weight in grams (e.g., 100, 500, 1000)') }}</small>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Default Delivery Charge (₹)') }}</label>
            <input type="number" step="0.01" name="default_delivery_charge" class="form-control"
            value="{{ old('default_delivery_charge', $deliveryCharge->default_delivery_charge ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Setting') }}</label>
            <select name="setting_type" id="setting_type" class="form-control" required>
                <option value="na" {{ (old('setting_type', $deliveryCharge->setting_type ?? '') === 'na') ? 'selected' : '' }}>{{ __('N/A') }}</option>
                <option value="min_order" {{ (old('setting_type', $deliveryCharge->setting_type ?? '') === 'min_order') ? 'selected' : '' }}>{{ __('Minimum Order') }}</option>
            </select>
        </div>

        @php
            $selectedSetting = old('setting_type', $deliveryCharge->setting_type ?? 'na');
        @endphp 

        <div class="mb-3 {{ $selectedSetting == 'min_order' ? '' : 'd-none' }}" id="minOrderField">
            <label class="form-label">{{ __('Minimum Order Amount') }}</label>
            <input type="number" step="0.01" name="min_order" class="form-control" value="{{ old('min_order', $deliveryCharge->min_order ?? '') }}">
        </div>

        <div class="mb-1">
            <small class="text-muted">
                {{ __('Example: If you enter 5 grams in the weight field and ₹50 in the delivery cost field, then users selecting this zone will be charged ₹50 for every 5 grams.') }}
            </small>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Delivery Cost') }}</label>
            <input type="number" step="0.01" name="delivery_charge" class="form-control" value="{{ old('delivery_charge', $deliveryCharge->delivery_charge ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($deliveryCharge) ? __('Update') : __('Save') }}</button>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const settingSelect = document.getElementById('setting_type');
        const minOrderField = document.getElementById('minOrderField');

        function toggleMinOrderField() {
            if (settingSelect.value === 'min_order') {
                minOrderField.classList.remove('d-none');
            } else {
                minOrderField.classList.add('d-none');
            }
        }

        // Initialize on page load
        toggleMinOrderField();

        // Add event listener for changes
        settingSelect.addEventListener('change', toggleMinOrderField);
    });
</script>