@extends('matrimony.layouts.app')

<style>
    .blur-image img {
        filter: blur(6px);
        transition: filter 0.3s ease;
    }
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
                    <div class="row g-4">
                        @foreach($profiles as $profile)
                            <!-- Profile cards here -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card profile-card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="profile-img mb-3">
                                            <div class="{{ $profile->visibility == 1 ? 'blur-image' : '' }}">
                                                {!! render_image_markup_by_attachment_id($profile->image, 'rounded-circle', '120x120') 
                                                    ?? '<img src="' . asset('images/default-profile.jpg') . '" class="rounded-circle" width="120" height="120" alt="Profile">' !!}
                                            </div>
                                        </div>
                                        <h5 class="mb-1">{{ $profile->name }}</h5>
                                        <p class="text-muted small mb-2">
                                            {{ $profile->age }} years • {{ ucfirst($profile->gender) }}
                                        </p>
                                        <p class="small text-truncate mb-3">{{ $profile->occupation }}</p>
                                        <a href="{{ route('matrimony.profile-details', $profile->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            View Profile
                                        </a>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamic caste loading based on religion
        $('#religion-select').change(function() {
            const religionId = $(this).val();
            const casteSelect = $('#caste-select');
            
            casteSelect.empty().append('<option value="">Any Caste</option>');
            
            if (religionId) {
                $.get(`/api/castes?religion_id=${religionId}`, function(data) {
                    data.forEach(caste => {
                        casteSelect.append(`<option value="${caste.id}">${caste.caste}</option>`);
                    });
                });
            }
        });

        // Dynamic state loading based on country
        $('#country-select').change(function() {
            const countryId = $(this).val();
            const stateSelect = $('#state-select');
            const citySelect = $('#city-select');
            
            stateSelect.empty().append('<option value="">Any State</option>');
            citySelect.empty().append('<option value="">Any City</option>');
            
            if (countryId) {
                $.get(`/api/states?country_id=${countryId}`, function(data) {
                    data.forEach(state => {
                        stateSelect.append(`<option value="${state.id}">${state.state}</option>`);
                    });
                });
            }
        });

        // Dynamic city loading based on state
        $('#state-select').change(function() {
            const stateId = $(this).val();
            const citySelect = $('#city-select');
            
            citySelect.empty().append('<option value="">Any City</option>');
            
            if (stateId) {
                $.get(`/api/cities?state_id=${stateId}`, function(data) {
                    data.forEach(city => {
                        citySelect.append(`<option value="${city.id}">${city.city}</option>`);
                    });
                });
            }
        });
    });
</script>
@endpush