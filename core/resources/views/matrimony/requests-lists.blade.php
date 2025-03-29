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
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SNo</th>
                                <th>Profile</th>
                                <th>Status</th>
                                <th>Request Sent on</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $request->profile->name ?? 'N/A' }}</td>
                                <td>
                                    @if(strtolower($request->status) == 'accepted')
                                        <span style="color: green;">{{ $request->status }}</span>
                                    @elseif(strtolower($request->status) == 'rejected')
                                        <span style="color: red;">{{ $request->status }}</span>
                                    @else
                                        {{ $request->status }}
                                    @endif
                                </td>
                                <td>{{ $request->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($requests->isEmpty())
                        <div class="alert alert-info">No requests found</div>
                    @endif
                    
                </div>
            </main>
        </div>
    </div>
</div>

@endsection