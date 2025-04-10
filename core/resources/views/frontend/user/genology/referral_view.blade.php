@extends('frontend.layout.master')

@section('content')
    <div class="container my-4">
        <h3 class="text-center mb-2">My Referral View</h3>
        <div class="text-center mb-4">
            <strong>Referral ID:</strong> {{ $parentUser->partner_id }}
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Distributor ID</th>
                        <th>Distributor Name</th>
                        <th>Position</th>
                        <th>Date</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referrals as $index => $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->partner_id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->position }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $city = $user->user_city->name ?? null;
                                                $state = $user->user_state->name ?? null;
                                                $country = $user->user_country->country ?? null;
                                            @endphp

                                            @if($city || $state || $country)
                                                {{ $city ? $city . ',' : '' }}
                                                {{ $state ? $state . ',' : '' }}
                                                {{ $country ?? '' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No referrals found for this user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection