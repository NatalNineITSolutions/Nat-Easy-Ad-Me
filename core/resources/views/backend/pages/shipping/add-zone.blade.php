@extends('backend.admin-master')

@section('site-title')
    {{ __('Add Zone') }}
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-4">{{ __('Add Shipping Zone') }}</h5>

            <form method="POST" action="{{ isset($zone) ? route('admin.shipping.update', $zone->id) : route('admin.shipping.store') }}">
            @csrf

                {{-- Zone Name --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Zone Name') }}</label>
                    <input
                        type="text"
                        name="zone_name"
                        class="form-control"
                        placeholder="{{ __('Enter Zone Name') }}"
                        value="{{ old('zone_name', $zone->zone_name ?? '') }}"
                        required>
                </div>

                {{-- Country --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Country') }}</label>
                    <select id="country" name="country" class="form-control">
                        <option value="">{{ __('Select Country') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ (old('country', $zone->country_id ?? '') == $country->id) ? 'selected' : '' }}>
                                {{ $country->country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- State --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('State') }}</label>
                    <select id="state" name="state" class="form-control">
                        <option value="">{{ __('Select State') }}</option>
                        @isset($states)
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ (old('state', $zone->state_id ?? '') == $state->id) ? 'selected' : '' }}>
                                    {{ $state->state }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary mt-3">
                    {{ __('Save Zone') }}
                </button>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country');
        const stateSelect   = document.getElementById('state');

        countrySelect.addEventListener('change', function () {
            const countryID = this.value;

            if (!countryID) {
            stateSelect.innerHTML = '<option value="">{{ __("Select State") }}</option>';
            stateSelect.disabled  = false;
            return;
            }

            // Show loading message and disable dropdown
            stateSelect.innerHTML = '<option selected disabled>{{ __("Loading...") }}</option>';
            stateSelect.disabled = true;

            fetch("{{ route('admin.shipping.get.states') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ country_id: countryID })
            })
            .then(res => res.json())
            .then(states => {
            stateSelect.disabled = false;
            stateSelect.innerHTML = ''; // Clear old options

            if (states.length === 0) {
                // No states found
                stateSelect.innerHTML = '<option selected disabled>{{ __("No states under selected country") }}</option>';
            } else {
                // Add default select option
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

