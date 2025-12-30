@extends('matrimony.layouts.app')

@section('style')
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Montserrat", sans-serif;
    }

    .profile-container {
        background-color: #FFFBEE;
        padding-top: 45px;
    }

    .main {
        border: 1px solid #F0F0F0;
        border-radius: 20px;
        padding: 20px 20px;
    }

    .main h2 {
        font-size: 14px;
        font-weight: 600;
    }

    form {
        margin-top: 25px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    label {
        font-size: 12px;
        font-weight: 600;
    }

    .form-control, .form-select {
        font-size: 12px;
        font-weight: 500;
    }

    .profile-settings {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .btn-secondary {
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
                    <div class="profile-settings">
                        <h2 class="mb-0">Edit Profile</h2>
                        <a href="{{ route('matrimony.profile') }}" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <form method="POST" action="{{ route('matrimony.update-profile', auth()->id()) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Username (readonly) -->
                            <div class="col-md-6 mb-3">
                                <label>Username</label>
                                <input type="text" class="form-control"
                                    value="{{ auth()->user()->username }}" readonly>
                            </div>

                            <!-- Marital Status -->
                            <div class="col-md-6 mb-3">
                                <label>Marital Status</label>
                                <select name="marital_status" class="form-select">
                                    @foreach(['unmarried','married','second marriage'] as $status)
                                        <option value="{{ $status }}"
                                            {{ ($userProfile->marital_status ?? '') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- DOB -->
                            <div class="col-md-6 mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ $userProfile->dob ?? '' }}">
                            </div>

                            <!-- Height -->
                            <div class="col-md-6 mb-3">
                                <label>Height (cm)</label>
                                <input type="number" name="height" class="form-control"
                                    value="{{ $userProfile->height ?? '' }}">
                            </div>

                            <!-- Weight -->
                            <div class="col-md-6 mb-3">
                                <label>Weight (kg)</label>
                                <input type="number" name="weight" class="form-control"
                                    value="{{ $userProfile->weight ?? '' }}">
                            </div>

                            <!-- Education -->
                            <div class="col-md-6 mb-3">
                                <label>Education</label>
                                <input type="text" name="education" class="form-control"
                                    value="{{ $userProfile->education ?? '' }}">
                            </div>

                            <!-- Occupation -->
                            <div class="col-md-6 mb-3">
                                <label>Occupation</label>
                                <input type="text" name="occupation" class="form-control"
                                    value="{{ $userProfile->occupation ?? '' }}">
                            </div>

                            <!-- Employed In -->
                            <div class="col-md-6 mb-3">
                                <label>Employed In</label>
                                <select name="employed_in" class="form-select">
                                    @foreach(['government','private','business','self_employed','not_working'] as $job)
                                        <option value="{{ $job }}"
                                            {{ ($userProfile->employed_in ?? '') == $job ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_',' ', $job)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Annual Income -->
                            <div class="col-md-6 mb-3">
                                <label>Annual Income</label>
                                <input type="number" name="annual_income" class="form-control"
                                    value="{{ $userProfile->annual_income ?? '' }}">
                            </div>

                            <!-- About -->
                            <div class="col-md-12 mb-3">
                                <label>About</label>
                                <textarea name="about" class="form-control" rows="3">{{ $userProfile->about ?? '' }}</textarea>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-3">
                            Save Changes
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
