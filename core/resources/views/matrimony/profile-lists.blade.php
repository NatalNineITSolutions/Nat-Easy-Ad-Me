@extends('matrimony.layouts.app') 

@section('style')
    <style>
        .profile-container {
            background-color: #FFFBEE;
            padding-top: 45px;
        }

        .main {
            border: 1px solid #F0F0F0;
            border-radius: 20px;
            padding: 10px 20px;
            margin-bottom: 30px;
        }

        .main h3 {
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            color: #66451C;
            margin-top: 25px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }

        tbody td {
            font-size: 13px;
            font-weight: 600;
        }
        
        .listing-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .listing-card {
            flex: 1;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .listing-card h4 {
            color: #66451C;
            margin-top: 0;
            font-size: 16px;
        }
        
        .listing-card p {
            font-size: 24px;
            font-weight: bold;
            color: #66451C;
            margin-bottom: 0;
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
                    <h3>Profile Lists</h3>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profiles as $index => $profile)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $profile->name }}</td>
                                    <td>{{ $profile->age }}</td>
                                    <td>
                                        @php
                                            $statusText = 'Pending';
                                            $statusColor = 'red';
                                            $rejectionReason = '';
                    
                                            if ($profile->is_verified == 1) {
                                                $statusText = 'Verified';
                                                $statusColor = 'green';
                                            } elseif ($profile->is_verified == 2) {
                                                $statusText = 'Rejected';
                                                $statusColor = 'gray';
                                                $rejectionReason = $profile->rejection_reason;
                                            }
                                        @endphp
                    
                                        <span style="color: {{ $statusColor }};">
                                            {{ $statusText }}
                                        </span>
                    
                                        @if($profile->is_verified == 2 && $rejectionReason)
                                            <br>
                                            <small class="text-muted">Reason: {{ $rejectionReason }}</small>
                                            <br>
                                            <!-- Refill Form Button -->
                                            <a href="/matrimony/update-profile/{{ $profile->id ?? '' }}" class="btn btn-sm btn-primary mt-2">
                                                Refill Form
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </main>
        </div>
    </div>
</div>

@endsection