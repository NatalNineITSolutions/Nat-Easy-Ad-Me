@extends('frontend.layout.master')

@section('content')
    <div class="container my-4">
        <h3 class="text-center mb-2">My Team view</h3>
        <div class="text-center mb-4">
            <strong>ID:</strong> {{ $parentUser->partner_id }}
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Referral ID</th>
                        <th>Parent ID</th>
                        <th>Distributor ID</th>
                        <th>Distributor Name</th>
                        <th>Position</th>
                        <th>City</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teamMembers as $index => $member)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($member->sponsor_id)
                                                {{ optional($allUsers->get($member->sponsor_id))->partner_id ?? $member->sponsor_id }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($member->parent_id)
                                                {{ optional($allUsers->get($member->parent_id))->partner_id ?? $member->parent_id }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $member->partner_id }}</td>
                                        <td>{{ $member->full_name }}</td>
                                        <td>{{ $member->position ?? 'N/A' }}</td>
                                        <td>{{ $user->user_city->city ?? 'N/A' }}</td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No team members found under this user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection