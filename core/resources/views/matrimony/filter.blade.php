@extends('matrimony.layouts.app')

<style>
    .blur-image img {
        filter: blur(6px);
        transition: filter 0.3s ease;
    }

     /* Compact profile card */
    .compact-grid { display:flex; flex-wrap:wrap; gap:1rem; margin:0 -0.5rem; }
    .compact-col { padding:0 0.5rem; width:100%; }

    @media(min-width:576px){ .compact-col { width:50%; } }   /* 2 cards */
    @media(min-width:900px){ .compact-col { width:33.3333%; } } /* 3 cards */
    @media(min-width:1400px){ .compact-col { width:25%; } }  /* 4 cards */

    .compact-card {
        display:flex;
        flex-direction:column;
        align-items:center;
        text-align:center;
        padding:12px;
        border-radius:10px;
        background:#fff;
        border:1px solid rgba(15,23,42,0.04);
        box-shadow:0 6px 14px rgba(16,24,40,0.03);
        transition:transform .12s ease, box-shadow .12s ease;
        height:100%;
    }

    .compact-card:hover { transform:translateY(-4px); box-shadow:0 10px 20px rgba(16,24,40,0.06); }

    .compact-avatar {
        width:80px;
        height:80px;
        border-radius:50%;
        overflow:hidden;
        margin-bottom:10px;
        display:inline-block;
        border:4px solid #fff;
        box-shadow:0 6px 12px rgba(16,24,40,0.06);
        background:#f8fafc;
    }

    .compact-avatar img { width:100%; height:100%; object-fit:cover; display:block; }

    .compact-name { font-size:0.98rem; font-weight:600; color:#0b2540; margin-bottom:4px; }
    .compact-meta { font-size:0.82rem; color:#6b7280; margin-bottom:6px; }
    .compact-occupation { font-size:0.82rem; color:#374151; margin-bottom:8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:100%; }

    .compact-badges { display:flex; gap:.35rem; justify-content:center; margin-bottom:8px; }
    .badge-compact { font-size:.7rem; padding:.18rem .45rem; border-radius:999px; background:#eef2ff; color:#3730a3; font-weight:700; }

    .compact-actions { margin-top:auto; }
    .btn-compact { padding:.35rem .7rem; font-size:.85rem; border-radius:999px; }

</style>

@section('content')
<div class="matrimony-filter-page py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-sliders-h me-2"></i>Refine Search
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('matrimony.filter') }}" method="GET">
                            <!-- Gender Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Gender</label>
                                <select name="gender" class="form-select form-select-sm">
                                    <option value="">Any Gender</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <!-- Age Range Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Age Range</label>
                                <select name="age_range" class="form-select form-select-sm">
                                    <option value="">Any Age</option>
                                    @foreach($filterOptions['ages'] as $age)
                                        <option value="{{ $age->id }}" 
                                            {{ request('age_range') == $age->id ? 'selected' : '' }}>
                                            {{ $age->from_age }} - {{ $age->to_age }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Marital Status -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Marital Status</label>
                                <select name="marital_status" class="form-select form-select-sm">
                                    <option value="">Any Status</option>
                                    @foreach($filterOptions['maritalStatuses'] as $status)
                                        <option value="{{ Str::slug($status) }}"
                                            {{ request('marital_status') == Str::slug($status) ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Income -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Minimum Income</label>
                                <select name="income" class="form-select form-select-sm">
                                    <option value="">Any Income</option>
                                    @foreach($filterOptions['income'] as $inc)
                                        <option value="{{ $inc->id }}" 
                                            {{ request('income') == $inc->id ? 'selected' : '' }}>
                                            {{ $inc->from_income }} - {{ $inc->to_income }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Occupation -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Occupation</label>
                                <input type="text" name="occupation" class="form-control form-control-sm" 
                                       placeholder="Doctor, Engineer, etc." value="{{ request('occupation') }}">
                            </div>

                            <!-- Religion -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Religion</label>
                                <select name="religion" class="form-select form-select-sm" id="religion-select">
                                    <option value="">Any Religion</option>
                                    @foreach($filterOptions['religions'] as $religion)
                                        <option value="{{ $religion->id }}" 
                                            {{ request('religion') == $religion->id ? 'selected' : '' }}>
                                            {{ $religion->religion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Caste -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Caste</label>
                                <select name="caste" class="form-select form-select-sm" id="caste-select">
                                    <option value="">Any Caste</option>
                                    @foreach($filterOptions['castes'] as $caste)
                                        <option value="{{ $caste->id }}" 
                                            {{ request('caste') == $caste->id ? 'selected' : '' }}>
                                            {{ $caste->caste }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Star/Zodiac -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Star Sign</label>
                                <select name="star" class="form-select form-select-sm">
                                    <option value="">Any Star</option>
                                    @foreach($filterOptions['stars'] as $star)
                                        <option value="{{ $star->id }}" 
                                            {{ request('star') == $star->id ? 'selected' : '' }}>
                                            {{ $star->star }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Zodiac Sign</label>
                                <select name="zodiac_sign" class="form-select form-select-sm">
                                    <option value="">Any Zodiac</option>
                                    @foreach($filterOptions['zodiacSigns'] as $zodiacsign)
                                        <option value="{{ $zodiacsign->id }}" 
                                            {{ request('zodiac_sign') == $zodiacsign->id ? 'selected' : '' }}>
                                            {{ $zodiacsign->zodiac_sign }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Location</label>
                                <select name="country" class="form-select form-select-sm mb-2" id="country-select">
                                    <option value="">Any Country</option>
                                    @foreach($filterOptions['countries'] as $country)
                                        <option value="{{ $country->id }}" 
                                            {{ request('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <select name="state" class="form-select form-select-sm mb-2" id="state-select">
                                    <option value="">Any State</option>
                                    @foreach($filterOptions['states'] as $state)
                                        <option value="{{ $state->id }}" 
                                            {{ request('state') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="city" class="form-select form-select-sm" id="city-select">
                                    <option value="">Any City</option>
                                    @foreach($filterOptions['cities'] as $city)
                                        <option value="{{ $city->id }}" 
                                            {{ request('city') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter me-1"></i> Apply Filters
                                </button>
                                <a href="{{ route('matrimony.filter') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-undo me-1"></i> Reset Filters
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Results Column -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-users me-2"></i>
                                @if($hasFilters)
                                    Filtered Profiles
                                @else
                                    All Verified Profiles
                                @endif
                            </h5>
                            <span class="badge bg-primary rounded-pill">{{ $profiles->total() }} profiles</span>
                        </div>
                        
                        @if($hasFilters)
                            <div class="mt-2">
                                <a href="{{ route('matrimony.filter') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-undo me-1"></i> Show All Profiles
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if($profiles->count() > 0)
                    <div class="compact-grid">
                        @foreach($profiles as $profile)
                            <div class="compact-col">
                                <div class="compact-card">
                                    <div class="{{ $profile->visibility == 1 ? 'blur-image' : '' }}">
                                        <div class="compact-avatar">
                                            {!! render_image_markup_by_attachment_id($profile->image, 'rounded-circle', '80x80')
                                            ?? '<img src="' . asset('images/default-profile.jpg') . '" alt="Profile">' !!}
                                        </div>
                                    </div>
                                    <div class="compact-name">{{ \Illuminate\Support\Str::limit($profile->name, 26) }}</div>
                                    <div class="compact-badges" aria-hidden="true">
                                        <span class="badge-compact">{{ $profile->age ?? '—' }} yrs</span>
                                        <span class="badge-compact">{{ ucfirst($profile->gender ?? '—') }}</span>
                                    </div>
                                    <div class="compact-meta">
                                        @php
                                        $loc = array_filter([optional($profile)->city, optional($profile)->state]);
                                        @endphp
                                        {{ $loc ? implode(', ', $loc) : '' }}
                                    </div>
                                    <div class="compact-occupation" title="{{ $profile->occupation ?? '' }}">
                                        {{ $profile->occupation ? \Illuminate\Support\Str::limit($profile->occupation, 30) : '—' }}
                                    </div>
                                    <div class="compact-actions">
                                        <a href="{{ route('matrimony.profile-details', $profile->id) }}" class="btn btn-sm btn-outline-primary btn-compact">View</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $profiles->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <div class="empty-state-icon">
                                <i class="fas fa-user-slash fa-3x text-muted"></i>
                            </div>
                            <h5 class="mt-3 mb-2">No matching profiles found</h5>
                            <p class="text-muted mb-4">Try adjusting your search filters or <a href="{{ route('matrimony.filter') }}">show all profiles</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Build base URLs using blade helpers (adjust prefix if routes are inside a group)
            const statesBase = "{{ url('get-states') }}"; // will become e.g. /get-states
            const citiesBase = "{{ url('get-cities') }}"; // will become e.g. /get-cities

            function setOptions($select, items, placeholderText) {
                $select.empty();
                $select.append(`<option value="">${placeholderText}</option>`);
                if (!items || !items.length) return;
                    items.forEach(it => {
                    $select.append(`<option value="${it.id}">${it.state || it.city || it.name || it}</option>`);
                });
            }

            // load states for countryId, optional selectedStateId to preselect after load
            function loadStates(countryId, selectedStateId = null) {
                const $state = $('#state');
                const $city = $('#city');
                setOptions($state, [], 'Choose state');
                setOptions($city, [], 'Choose city');

                if (!countryId) return;

                $.ajax({
                    url: `${statesBase}/${countryId}`,
                    method: 'GET',
                    dataType: 'json'
                }).done(function(res) {
                    // Expecting { states: [...] }
                    const list = res && res.states ? res.states : [];
                    setOptions($state, list, 'Choose state');
                    if (selectedStateId) $state.val(selectedStateId).trigger('change');
                }).fail(function(xhr, status, err) {
                    console.error('Failed to load states', status, err);
                    setOptions($state, [], 'Choose state');
                });
            }

            // load cities for stateId, optional selectedCityId
            function loadCities(stateId, selectedCityId = null) {
                const $city = $('#city');
                setOptions($city, [], 'Choose city');
                if (!stateId) return;

                $.ajax({
                    url: `${citiesBase}/${stateId}`,
                    method: 'GET',
                    dataType: 'json'
                }).done(function(res) {
                    // Expecting { cities: [...] }
                    const list = res && res.cities ? res.cities : [];
                    setOptions($city, list, 'Choose city');
                    if (selectedCityId) $city.val(selectedCityId);
                }).fail(function(xhr, status, err) {
                    console.error('Failed to load cities', status, err);
                    setOptions($city, [], 'Choose city');
                });
            }

            // event handlers
            $('#country').on('change', function() {
                const countryId = $(this).val();
                loadStates(countryId);
            });

            $('#state').on('change', function() {
                const stateId = $(this).val();
                loadCities(stateId);
            });

            // On page load: if server preselected values or user reloaded
            const initialCountry = $('#country').val() || "{{ request('country') ?? '' }}";
            const initialState = $('#state').val() || "{{ request('state') ?? '' }}";
            const initialCity = $('#city').val() || "{{ request('city') ?? '' }}";

            if (initialCountry) {
                // load states then select state -> cities will be triggered by state change
                loadStates(initialCountry, initialState);
                // if state already present then load cities after short delay as fallback
                if (initialState) {
                    // ensure cities are loaded if state wasn't in server output
                    loadCities(initialState, initialCity);
                }
            } else if (initialState) {
            // unlikely but handle: load cities for provided state
            loadCities(initialState, initialCity);
            }
        });
    </script>

@endpush
<!-- Force jQuery Load -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Verify script is running
        console.log("Filter Script Loaded!"); 

        // Routes
        var getStatesUrl = "{{ route('matrimony.get-states', '0') }}";
        var getCitiesUrl = "{{ route('matrimony.get-cities', '0') }}";

        // 1. Country Change
        $('#country-select').on('change', function() {
            console.log("Country Changed to: " + $(this).val()); // Debug log

            var countryId = $(this).val();
            var $state = $('#state-select');
            var $city = $('#city-select');

            // Reset
            $state.html('<option value="">Any State</option>');
            $city.html('<option value="">Any City</option>');

            if (countryId) {
                // Replace '0' with actual ID
                var url = getStatesUrl.replace('/0', '/' + countryId);
                
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("States loaded:", data); // Debug log
                        if (data.states) {
                            $.each(data.states, function(key, value) {
                                $state.append('<option value="' + value.id + '">' + value.state + '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr);
                    }
                });
            }
        });

        // 2. State Change
        $('#state-select').on('change', function() {
            console.log("State Changed to: " + $(this).val()); // Debug log

            var stateId = $(this).val();
            var $city = $('#city-select');

            $city.html('<option value="">Any City</option>');

            if (stateId) {
                var url = getCitiesUrl.replace('/0', '/' + stateId);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data.cities) {
                            $.each(data.cities, function(key, value) {
                                $city.append('<option value="' + value.id + '">' + value.city + '</option>');
                            });
                        }
                    }
                });
            }
        });
    });
</script>

