@extends('matrimony.layouts.app')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    .profile-container {
        background-color: #FFFBEE;
        padding-top: 45px;
    }

    .main {
        border: 1px solid #F0F0F0;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .main h3 {
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        color: #66451C;
        margin-bottom: 25px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        font-size: 13px;
    }

    th {
        background-color: #F9F6EF;
        font-weight: 600;
        color: #66451C;
        width: 35%;
    }

    td {
        font-weight: 500;
        color: #333;
    }

    .btn-edit {
        background-color: #66451C;
        color: #fff;
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 20px;
        text-decoration: none;
    }

    .btn-edit:hover {
        background-color: #523818;
        color: #fff;
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
                        <h3 class="mb-0">Preference Details</h3>

                        <a href="{{ route('matrimony.preference.edit') }}" class="btn-edit">
                            Edit Preference
                        </a>
                    </div>

                    @if($preferences)
                        <table>
                            <tbody>
                                <tr>
                                    <th>Preferred Age</th>
                                    <td>{{ $preferences->partner_age ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Preferred Gender</th>
                                    <td>{{ ucfirst($preferences->gender) ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Marital Status</th>
                                    <td>{{ $preferences->marital_status ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Religion</th>
                                    <td>{{ $preferences->religion ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Caste</th>
                                    <td>{{ $preferences->caste ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mother Tongue</th>
                                    <td>{{ $preferences->mother_tongue ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{ $preferences->occupation ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Annual Income</th>
                                    <td>{{ $preferences->income ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Zodiac Sign</th>
                                    <td>
                                        {{ $preferences->zodiac_sign
                                            ? implode(', ', explode('|', $preferences->zodiac_sign))
                                            : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Star</th>
                                    <td>
                                        {{ $preferences->star
                                            ? implode(', ', explode('|', $preferences->star))
                                            : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Preferred Location</th>
                                    <td>{{ $preferences->location ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">
                            Preference details not available.
                        </p>
                    @endif

                </div>
            </main>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Choices('select[name="zodiac_sign[]"]', {
        removeItemButton: true,
        placeholderValue: 'Select Zodiac Signs',
        searchPlaceholderValue: 'Search...'
    });

    new Choices('select[name="star[]"]', {
        removeItemButton: true,
        placeholderValue: 'Select Stars',
        searchPlaceholderValue: 'Search...'
    });
});
</script>
@endsection

