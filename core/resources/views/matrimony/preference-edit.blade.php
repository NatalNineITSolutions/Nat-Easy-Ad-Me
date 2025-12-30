@extends('matrimony.layouts.app')

@section('style')
<style>
    * {
        font-family: "Montserrat", sans-serif;
    }

    .profile-container {
        background-color: #FFFBEE;
        padding-top: 45px;
        min-height: 100vh;
    }

    .main {
        border: 1px solid #F0F0F0;
        border-radius: 20px;
        padding: 25px;
        background: #fff;
        margin-bottom: 30px;
    }

    .main h3 {
        font-size: 16px;
        font-weight: 600;
        color: #66451C;
        margin-bottom: 20px;
    }

    label {
        font-size: 12px;
        font-weight: 600;
    }

    .form-control,
    .form-select {
        font-size: 12px;
        font-weight: 500;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    .btn-save {
        background-color: #FF0066;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 25px;
        border: none;
    }

    .btn-back {
        font-size: 12px;
        font-weight: 600;
        border-radius: 25px;
    }
</style>
@endsection

@section('content')

<div>
    @include('matrimony.partials.banner')
</div>

<div class="profile-container">
    <div class="container">
        <div class="row gx-3">
            @include('matrimony.partials.sidebar')

            <main class="col-md-8 col-lg-9 px-md-4">
                <div class="main">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Edit Preference</h3>
                        <a href="{{ route('matrimony.preference.table') }}" class="btn btn-secondary btn-back">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <form id="preferenceEditForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Partner Age --}}
                            <div class="col-md-6">
                                <label>Partner Age</label>
                                <select class="form-select" name="partner_age">
                                    <option value="">Select</option>
                                    @foreach($ages as $age)
                                        @php
                                            $range = $age->from_age.' - '.$age->to_age;
                                        @endphp
                                        <option value="{{ $range }}"
                                            {{ ($preferences->partner_age ?? '') == $range ? 'selected' : '' }}>
                                            {{ $range }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-6">
                                <label>Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select</option>
                                    <option value="male" {{ ($preferences->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ ($preferences->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ ($preferences->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            {{-- Mother Tongue --}}
                            <div class="col-md-6">
                                <label>Mother Tongue</label>
                                <select class="form-select" name="mother_tongue">
                                    <option value="">Select</option>
                                    @foreach($motherTongues as $tongue)
                                        <option value="{{ $tongue->id }}"
                                            {{ ($preferences->mother_tongue ?? '') == $tongue->id ? 'selected' : '' }}>
                                            {{ $tongue->mother_tongue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Location --}}
                            <div class="col-md-6">
                                <label>Location</label>
                                <input type="text" class="form-control" name="location"
                                    value="{{ $preferences->location ?? '' }}">
                            </div>

                            {{-- Zodiac --}}
                            <div class="col-md-6">
                                <label>Zodiac Sign</label>
                                @php
                                    $selectedZodiac = $preferences && $preferences->zodiac_sign
                                        ? explode('|', $preferences->zodiac_sign)
                                        : [];
                                @endphp
                                <select name="zodiac_sign[]" class="form-select" multiple>
                                    @foreach($zodiacsigns as $zodiac)
                                        <option value="{{ $zodiac->id }}"
                                            {{ in_array($zodiac->id, $selectedZodiac) ? 'selected' : '' }}>
                                            {{ $zodiac->zodiac_sign }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Star --}}
                            <div class="col-md-6">
                                <label>Star</label>
                                @php
                                    $selectedStars = $preferences && $preferences->star
                                        ? explode('|', $preferences->star)
                                        : [];
                                @endphp
                                <select name="star[]" class="form-select" multiple>
                                    @foreach($stars as $star)
                                        <option value="{{ $star->id }}"
                                            {{ in_array($star->id, $selectedStars) ? 'selected' : '' }}>
                                            {{ $star->star }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Religion --}}
                            <div class="col-md-6">
                                <label>Religion</label>
                                <select class="form-select" name="religion">
                                    <option value="">Select</option>
                                    @foreach($religions as $religion)
                                        <option value="{{ $religion->id }}"
                                            {{ ($preferences->religion ?? '') == $religion->id ? 'selected' : '' }}>
                                            {{ $religion->religion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Caste --}}
                            <div class="col-md-6">
                                <label>Caste</label>
                                <select class="form-select" name="caste">
                                    <option value="">Select</option>
                                    @foreach($castes as $caste)
                                        <option value="{{ $caste->id }}"
                                            {{ ($preferences->caste ?? '') == $caste->id ? 'selected' : '' }}>
                                            {{ $caste->caste }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Height --}}
                            <div class="col-md-6">
                                <label>Height</label>
                                <input type="text" class="form-control" name="height"
                                    value="{{ $preferences->height ?? '' }}">
                            </div>

                            {{-- Weight --}}
                            <div class="col-md-6">
                                <label>Weight</label>
                                <input type="text" class="form-control" name="weight"
                                    value="{{ $preferences->weight ?? '' }}">
                            </div>

                            {{-- Occupation --}}
                            <div class="col-md-6">
                                <label>Occupation</label>
                                <input type="text" class="form-control" name="occupation"
                                    value="{{ $preferences->occupation ?? '' }}">
                            </div>

                            {{-- Marital Status --}}
                            <div class="col-md-6">
                                <label>Marital Status</label>
                                <select class="form-select" name="marital_status">
                                    <option value="">Select</option>
                                    @foreach($marital_status as $status)
                                        <option value="{{ $status }}"
                                            {{ ($preferences->marital_status ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Income --}}
                            <div class="col-md-12">
                                <label>Monthly Income</label>
                                <select class="form-select" name="income">
                                    <option value="">Select</option>
                                    @foreach($income as $inc)
                                        @php
                                            $range = $inc->from_income.' - '.$inc->to_income;
                                        @endphp
                                        <option value="{{ $range }}"
                                            {{ ($preferences->income ?? '') == $range ? 'selected' : '' }}>
                                            {{ $range }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn-save">
                                    Save Changes
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </main>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
document.getElementById('preferenceEditForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch("{{ route('matrimony.preference.update') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success || !data.error){
            window.location.href = "{{ route('matrimony.preference.table') }}";
        }
    })
    .catch(() => alert('Something went wrong'));
});
</script>
@endsection
