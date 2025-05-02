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

        .account-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(240, 240, 240, 1);
        }

        .account-heading h5 {
            padding-bottom: 0px;
        }

        .btn-outline-primary {
            border-radius: 25px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .btn-outline-primary i {
            margin-right: 5px;
        }

        tbody {
            color: rgba(102, 69, 28, 1);
        }

        .table td {
            padding: 12px 0;
            border-bottom: 2px solid rgba(240, 240, 240, 1);
            font-size: 12px;
        }

        .table-borderless tr:last-child td {
            border-bottom: none;
        }

        .label {
            color: #7b6148;
            font-weight: 500;
        }

        .value {
            color: #3d2b1f;
            font-weight: 500;
            text-align: left;
        }

        .main h2 {
            font-size: 16px;
            font-weight: 600;
            padding-bottom: 13px;
            border-bottom: 2px solid rgba(240, 240, 240, 1);
        }

        .profile-card {
            margin: 15px 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
        }

        .profile-card p {
            font-size: 12px;
            font-weight: 600;
        }

        .profile-setting {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-select {
            background-color: rgba(240, 240, 240, 1);
            font-size: 12px;
            font-weight: 600;
        }

        .profile-setting p {
            font-size: 12px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div>
        @include('matrimony.partials.banner')
    </div>
    <div class="profile-container">
        <div class="container ">
            <div class="row gx-3">
                @include('matrimony.partials.sidebar') <!-- Include the sidebar -->

                <main class="col-md-8 col-lg-9 px-md-4">
                    <div class="main">
                        <h2 class="mb-0">Profile Settings</h2>

                        <!-- Profile Info -->
                        <div class="profile-card">
                            <h5> {{ auth()->user()->username ?? auth()->user()->name }} </h5>
                            <p class="text-muted">Premium User | 1 Month</p>
                        </div>

                        <!-- Profile Visibility -->
                        <div class="profile-setting mt-2">
                            <div>
                                <h6>Profile Visible</h6>
                                <p class="text-muted mb-0">You can set who can view your profile.</p>
                            </div>
                            <select class="form-select w-auto">
                                <option>All Users</option>
                                <option>Only Matched Users</option>
                            </select>
                        </div>

                        <!-- Interest Requests -->
                        <div class="profile-setting mt-4">
                            <div>
                                <h6>Who can send you interest requests?</h6>
                                <p class="text-muted mb-0">You can set who can make interest requests here</p>
                            </div>
                            <select class="form-select w-auto">
                                <option>All Users</option>
                                <option>Only Matched Users</option>
                            </select>
                        </div>

                        <!-- Account Details -->
                        <div class="account-details mt-4 p-3">
                            <div class="account-heading">
                                <h5 class="mb-0">Account</h5>
                                <a href="{{ route('matrimony.edit-profile', auth()->id()) }}"
                                    class="btn btn-outline-primary">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                            </div>
                            <div class="table-responsive">
                                @if ($kycRecord)
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="label"><strong>Username</strong></td>
                                                <td class="value">{{ $kycRecord->username ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="label"><strong>Education</strong></td>
                                                <td class="value">{{ $kycRecord->education ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="label"><strong>Occupation</strong></td>
                                                <td class="value">{{ $kycRecord->occupation ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="label"><strong>Annual Income</strong></td>
                                                <td class="value">
                                                    {{ isset($kycRecord->annual_income) ? '₹' . number_format($kycRecord->annual_income) : 'N/A' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>No profile information available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
@endsection
