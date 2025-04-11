@extends('frontend.layout.master')

@section('content')
<div class="container-fluid my-4">
    <h3 class="text-center mb-2">My Referral View</h3>
    <div class="text-center mb-4">
        <strong>Referral ID:</strong> {{ $parentUser->partner_id }}
    </div>

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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No referrals found for this user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Referral Tree View --}}
    <h4 class="text-center mb-3">Referral Tree Structure</h4>
    <div class="mlm-tree-wrapper d-flex justify-content-center">
        @include('frontend.user.genology.partials.referral-tree-node', ['node' => $referralTree])
    </div>
</div>

    <style>
        .mlm-tree-wrapper {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .tree-node {
            text-align: center;
            position: relative;
            display: inline-block;
            margin: 20px auto;
        }

        .container-fluid {
            padding: 0 60px;
        }

        .node-card {
            background-color: #fff;
            border-radius: 10px;
            border: 2px solid #ccc;
            padding: 10px;
            display: inline-block;
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

        .children-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            position: relative;
            flex-wrap: wrap;
            gap: 10px;
        }

        .children-wrapper::before {
            content: "";
            position: absolute;
            top: -20px;
            left: 0;
            right: 0;
            height: 20px;
            border-top: 2px solid #ccc;
            margin: 0 auto;
        }

        .children-wrapper>.tree-node::before {
            content: "";
            position: absolute;
            top: -30px;
            left: 50%;
            width: 2px;
            height: 30px;
            background: #ccc;
            transform: translateX(-50%);
        }

        .node-details span {
            display: block;
            font-size: 14px;
            color: #333;
        }

        /* For desktop - center the initial tree */
        @media (min-width: 992px) {
            .mlm-tree-wrapper {
                display: flex;
                justify-content: center;
            }

            .tree-root {
                display: inline-block;
            }
        }

        /* Responsive styles for tablets */
        @media (max-width: 991px) {
            .container-fluid {
                padding: 0 30px;
            }

            .children-wrapper {
                gap: 20px;
            }
        }

        /* Responsive styles for small screens */
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

            .children-wrapper {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-top: 20px;
            }

            .tree-node {
                margin: 10px auto;
            }

            .mlm-tree-wrapper {
                padding: 10px;
                overflow-x: hidden;
            }

            .container-fluid {
                padding: 0 10px;
            }
        }
    </style>
@endsection