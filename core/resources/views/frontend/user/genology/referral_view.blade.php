@extends('frontend.layout.master')

@section('content')
    <div class="container-fluid my-4">
        <h3 class="text-center mb-2">My Direct Team</h3>
        <div class="text-center mb-4">
            <strong>Referral ID:</strong> {{ $parentUser->partner_id }}
        </div>

        {{-- Root user at the top --}}
        <div class="text-center mb-4">
            @include('frontend.user.genology.partials.referral-tree-node', ['node' => ['user' => $referralTree['user']], 'isRoot' => true])
        </div>

        {{-- Child users: centered on desktop, slider on mobile --}}
        @if (!empty($referralTree['children']) && count($referralTree['children']) > 0)
            <div class="mlm-tree-slider-wrapper">
                <div class="mlm-tree-slider">
                    @foreach ($referralTree['children'] as $child)
                        @include('frontend.user.genology.partials.referral-tree-node', ['node' => ['user' => $child]])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Referral Table --}}
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Distributor ID</th>
                        <th>Distributor Name</th>
                        <th>Position</th>
                        <th>Date</th>
                        <th>City</th>
                        <th>State</th>
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
                            <td>{{ $user->user_city->city ?? 'N/A' }}</td>
                            <td>{{ $user->user_state->state ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No referrals found for this user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Root & tree node styles */
        .tree-node {
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }

        .root-user {
            display: inline-block;
            margin-bottom: 20px;
        }

        .table-responsive {
            padding-left: 30px;
            padding-right: 30px;
        }

        .node-card {
            background-color: #fff;
            border-radius: 10px;
            border: 2px solid #ccc;
            padding: 10px;
            min-width: 160px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .node-card.paid {
            border-color: green;
        }

        .node-card.free {
            border-color: #999;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #ccc;
        }

        .node-details span {
            display: block;
            font-size: 14px;
            color: #333;
        }

        /* Slider wrapper for child nodes */
        .mlm-tree-slider-wrapper {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            padding: 20px;
        }

        /* Child nodes container */
        .mlm-tree-slider {
            display: flex;
            gap: 20px;
            justify-content: center;
            /* Center on desktop */
            flex-wrap: nowrap;
            /* Keep in a single line for sliding */
        }

        /* Mobile responsive tweaks */
        @media (max-width: 576px) {
            .node-card {
                min-width: 120px;
                padding: 6px;
            }

            .user-avatar {
                width: 45px;
                height: 45px;
                margin-bottom: 6px;
            }

            .node-details span {
                font-size: 12px;
            }

            .mlm-tree-slider-wrapper {
                padding: 10px;
            }

            .mlm-tree-slider {
                justify-content: flex-start;
                /* Align to left in slider mode */
            }

            .table-responsive {
                padding-left: 0px;
                padding-right: 0px;
            }
        }
    </style>
@endsection