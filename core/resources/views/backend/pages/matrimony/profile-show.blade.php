@extends('backend.admin-master')
@section('site-title')
    {{__('All User Listings')}}
@endsection

@section('style')
    <style>
         table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Mild background for even rows */
        }

        h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-accept {
            background-color: green;
            color: white;
        }

        .btn-reject {
            background-color: red;
            color: white;
        }

        .btn-accept:hover {
            background-color: green;
            color: white;
        }

        .btn-reject:hover {
            background-color: red;
            color: white;
        }
    </style>
@endsection

@section('content')
<div class="row g-4 mt-0">
    <div class="col-xl-12 col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Profile Details Title -->
            <h3 class="mb-0">Profile Details</h3>
        
            <!-- Back Button -->
            <a href="{{ route('admin.matrimony.profiles') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <!-- Profile Name -->
                    <div class="col-md-6">
                        <h5>Name</h5>
                        <p>{{ $profile->name }}</p>
                    </div>
            
                    <!-- Profile Age -->
                    <div class="col-md-6">
                        <h5>Age</h5>
                        <p>{{ $profile->age ?? 'N/A' }}</p>
                    </div>
                </div>
            
                <div class="row mb-4">
                    <!-- Profile Occupation -->
                    <div class="col-md-6">
                        <h5>Occupation</h5>
                        <p>{{ $profile->occupation }}</p>
                    </div>
            
                    <!-- Profile Annual Income -->
                    <div class="col-md-6">
                        <h5>Annual Income</h5>
                        <p>₹{{ number_format($profile->annual_income, 2) }}</p>
                    </div>
                </div>
            
                <div class="row mb-4">
                    <!-- Profile Caste -->
                    <div class="col-md-6">
                        <h5>Caste</h5>
                        <p>{{ $profile->caste ?? 'N/A' }}</p>
                    </div>
            
                    <!-- Profile Mother Tongue -->
                    <div class="col-md-6">
                        <h5>Mother Tongue</h5>
                        <p>{{ $profile->mother_tongue ?? 'N/A' }}</p>
                    </div>
                </div>
            
                <div class="row mb-4">
                    <!-- Profile Location -->
                    <div class="col-md-6">
                        <h5>Location</h5>
                        <p>{{ $profile->city ?? 'N/A' }},
                            {{ $profile->state ?? 'N/A' }},
                            {{ $profile->country ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h5>Verification Status</h5>
                        <p>
                            @if($profile->is_verified == 1)
                                <span class="badge bg-success">Verified</span>
                            @elseif($profile->is_verified == 2)
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div> 
</div>
@endsection 