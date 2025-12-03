@extends('backend.admin-master')

@section('site-title')
    {{ __('User Reports') }}
@endsection

@section('style')
    <style>
        .table th,
        .table td {
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard__card {
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
        }

        .dashboard__inner__header__title {
            font-size: 20px;
            font-weight: 600;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .pagination .page-link {
            padding: 6px 12px;
            margin: 0 3px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
        }

        .pagination .active .page-link {
            background-color: #009a22;
            color: #fff;
            border-color: #009a22;
        }
    </style>
@endsection

@section('content')
    <div class="row g-4 mt-0">
        <div class="col-xl-12 col-lg-12">
            <div class="dashboard__card">
                <div class="dashboard__inner__header mb-4">
                    <h4 class="dashboard__inner__header__title">{{ __('User Reports') }}</h4>
                </div>

                <div class="table-responsive">
                    <a href="{{ route('admin.user.reports.pdf') }}"
   class="cmnBtn btn_5 btn_bg_blue radius-5 ms-2 mb-3"
   target="_blank">
   Download PDF
</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th rowspan="2">S.No</th>
                                <th rowspan="2">Partner ID</th>
                                <th rowspan="2">Username</th>
                                <th rowspan="2">Membership</th>
                                <th colspan="3" class="text-center">BV History</th>
                                <th colspan="3" class="text-center">Order Details</th>
                            </tr>
                            <tr>
                                <th>BV Points</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                @php
                                    $bvCount = $user->bvHistory->count();
                                    $orderDetails = $user->orderDetails;
                                    $orderCount = $orderDetails->count();
                                    $maxRowspan = max($bvCount, $orderCount, 1);
                                @endphp

                                @for($i = 0; $i < $maxRowspan; $i++)
                                    <tr>
                                        @if($i === 0)
                                            <td rowspan="{{ $maxRowspan }}">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                            <td rowspan="{{ $maxRowspan }}">{{ $user->partner_id }}</td>
                                            <td rowspan="{{ $maxRowspan }}">{{ $user->username }}</td>
                                            <td rowspan="{{ $maxRowspan }}">
                                                {{ optional(optional($user->membership)->membership)->title ?? 'Free' }}
                                            </td>
                                        @endif

                                        {{-- BV History --}}
                                        <td>
                                            {{ $bvCount > $i ? $user->bvHistory[$i]->bv_points : '' }}
                                        </td>
                                        <td>
                                            {{ $bvCount > $i ? ucfirst($user->bvHistory[$i]->type) : '' }}
                                        </td>
                                        <td>
                                            {{ $bvCount > $i ? $user->bvHistory[$i]->created_at->format('d M Y h:i A') : '' }}
                                        </td>

                                        {{-- Order Details --}}
                                        <td>
                                            @if ($orderCount > 0 && isset($orderDetails[$i]))
                                                @php
                                                    $productIds = explode('|', $orderDetails[$i]->product_id);
                                                    $productNames = \App\Models\Product::whereIn('id', $productIds)->pluck('name', 'id');
                                                    echo collect($productIds)->map(fn($id) => $productNames[$id] ?? 'N/A')->implode(' | ');
                                                @endphp
                                            @elseif ($i === 0)
                                                <span class="text-danger">No orders found</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $orderCount > $i ? '₹' . number_format($orderDetails[$i]->grand_total ?? 0, 2) : '' }}
                                        </td>
                                        <td>
                                            {{ $orderCount > $i ? \Carbon\Carbon::parse($orderDetails[$i]->created_at)->format('d M Y') : '' }}
                                        </td>
                                    </tr>
                                @endfor
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-danger">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
