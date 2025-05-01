@extends('matrimony.layouts.app')

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
                                    <option value="18-25" {{ request('age_range') == '18-25' ? 'selected' : '' }}>18-25 Years</option>
                                    <option value="26-30" {{ request('age_range') == '26-30' ? 'selected' : '' }}>26-30 Years</option>
                                    <option value="31-35" {{ request('age_range') == '31-35' ? 'selected' : '' }}>31-35 Years</option>
                                    <option value="36-40" {{ request('age_range') == '36-40' ? 'selected' : '' }}>36-40 Years</option>
                                    <option value="41-50" {{ request('age_range') == '41-50' ? 'selected' : '' }}>41-50 Years</option>
                                    <option value="51-60" {{ request('age_range') == '51-60' ? 'selected' : '' }}>51-60 Years</option>
                                </select>
                            </div>

                            <!-- Marital Status -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Marital Status</label>
                                <select name="marital_status" class="form-select form-select-sm">
                                    <option value="">Any Status</option>
                                    <option value="single" {{ request('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="divorced" {{ request('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ request('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>

                            <!-- Income -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Minimum Income</label>
                                <select name="income" class="form-select form-select-sm">
                                    <option value="">Any Income</option>
                                    <option value="100000" {{ request('income') == '100000' ? 'selected' : '' }}>₹1 Lakh+</option>
                                    <option value="300000" {{ request('income') == '300000' ? 'selected' : '' }}>₹3 Lakh+</option>
                                    <option value="500000" {{ request('income') == '500000' ? 'selected' : '' }}>₹5 Lakh+</option>
                                    <option value="1000000" {{ request('income') == '1000000' ? 'selected' : '' }}>₹10 Lakh+</option>
                                    <option value="2000000" {{ request('income') == '2000000' ? 'selected' : '' }}>₹20 Lakh+</option>
                                </select>
                            </div>

                            <!-- Occupation -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Occupation</label>
                                <input type="text" name="occupation" class="form-control form-control-sm" 
                                       placeholder="Doctor, Engineer, etc." value="{{ request('occupation') }}">
                            </div>

                            <!-- Religion/Caste -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Religion</label>
                                <select name="religion" class="form-select form-select-sm">
                                    <option value="">Any Religion</option>
                                    <option value="hindu" {{ request('religion') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="muslim" {{ request('religion') == 'muslim' ? 'selected' : '' }}>Muslim</option>
                                    <option value="christian" {{ request('religion') == 'christian' ? 'selected' : '' }}>Christian</option>
                                    <option value="sikh" {{ request('religion') == 'sikh' ? 'selected' : '' }}>Sikh</option>
                                    <option value="other" {{ request('religion') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Caste</label>
                                <input type="text" name="caste" class="form-control form-control-sm" 
                                       placeholder="Enter caste" value="{{ request('caste') }}">
                            </div>

                            <!-- Star/Zodiac -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Star Sign</label>
                                <select name="star" class="form-select form-select-sm">
                                    <option value="">Any Star</option>
                                    @foreach(['Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces'] as $star)
                                        <option value="{{ $star }}" {{ request('star') == $star ? 'selected' : '' }}>{{ $star }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Zodiac Sign</label>
                                <select name="zodiac_sign" class="form-select form-select-sm">
                                    <option value="">Any Zodiac</option>
                                    @foreach(['Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces'] as $zodiac)
                                        <option value="{{ $zodiac }}" {{ request('zodiac_sign') == $zodiac ? 'selected' : '' }}>{{ $zodiac }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Location</label>
                                <select name="country" class="form-select form-select-sm mb-2">
                                    <option value="">Any Country</option>
                                    <option value="India" {{ request('country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="USA" {{ request('country') == 'USA' ? 'selected' : '' }}>USA</option>
                                    <option value="UK" {{ request('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                </select>
                                
                                <input type="text" name="state" class="form-control form-control-sm mb-2" 
                                       placeholder="State" value="{{ request('state') }}">
                                
                                <input type="text" name="city" class="form-control form-control-sm" 
                                       placeholder="City" value="{{ request('city') }}">
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
                                <i class="fas fa-users me-2"></i>Search Results
                            </h5>
                            <span class="badge bg-primary rounded-pill">{{ $profiles->total() }} profiles</span>
                        </div>
                    </div>
                </div>

                @if($profiles->count() > 0)
                    <div class="row g-4">
                        @foreach($profiles as $profile)
                            <div class="col-md-6 col-lg-4">
                                <div class="card profile-card h-100 border-0 shadow-sm">
                                    <a href="{{ route('matrimony.profile-details', $profile->id) }}" class="text-decoration-none text-dark">
                                        <div class="profile-image-container">
                                            @if($profile->image)
                                                <img src="{{ get_attachment_image_by_id($profile->image)['img_url'] }}" 
                                                     class="card-img-top profile-image" 
                                                     alt="{{ $profile->name }}"
                                                     loading="lazy">
                                            @else
                                                <img src="/assets/uploads/media-uploader/profile.png" 
                                                     class="card-img-top profile-image" 
                                                     alt="Default profile"
                                                     loading="lazy">
                                            @endif
                                            <div class="profile-overlay"></div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title mb-1">{{ $profile->name }}</h5>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-light text-dark me-2">
                                                    <i class="fas fa-birthday-cake me-1"></i> {{ $profile->age }} yrs
                                                </span>
                                                @if($profile->occupation)
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-briefcase me-1"></i> {{ $profile->occupation }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                                <small class="text-muted">
                                                    {{ $profile->city ?? '' }} {{ $profile->state ?? '' }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
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
                            <h5 class="mt-3 mb-2">No profiles found</h5>
                            <p class="text-muted mb-4">Try adjusting your search filters to find more matches</p>
                            <a href="{{ route('matrimony.filter') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-undo me-1"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .matrimony-filter-page {
        background-color: #f8f9fa;
    }
    
    .profile-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .profile-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .profile-image {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .profile-card:hover .profile-image {
        transform: scale(1.05);
    }
    
    .profile-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    }
    
    .empty-state-icon {
        opacity: 0.6;
        margin-bottom: 20px;
    }
    
    .form-select-sm, .form-control-sm {
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }
    
    .card-header {
        padding: 0.75rem 1.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add any necessary JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // You can add filter interaction enhancements here
    });
</script>
@endpush