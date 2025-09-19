@extends('frontend.layout.master')

@section('site-title')
    {{ __('User Reports') }}
@endsection

@section('content')
    <div class="profile-setting setting-page section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')

                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')

                            <div class="main-body">
                                <x-frontend.user.responsive-icon />

                                <div class="setting-btn-part">
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="tab-content-wraper box-shadow1 p-4">

                                                <div class="row g-4 mt-0">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="dashboard__card">
                                                            <div class="dashboard__inner__header mb-4">
                                                                <h4 class="dashboard__inner__header__title">
                                                                    {{ __('User Reports') }}
                                                                </h4>
                                                            </div>

                                                            <div class="table-responsive border border-light-subtle rounded">
                                                                <table class="table table-bordered border-light-subtle text-sm">
                                                                    <thead>
                                                                        <tr>
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
                                                                        @php
                                                                            $bvCount = $user->bvHistory->count();
                                                                            $orderDetails = $user->orderDetails;
                                                                            $orderCount = $orderDetails->count();
                                                                            $maxRowspan = max($bvCount, $orderCount, 1);
                                                                        @endphp

                                                                        @for($i = 0; $i < $maxRowspan; $i++)
                                                                            <tr>
                                                                                @if($i === 0)
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
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> {{-- /.row --}}
                                            </div> {{-- /.tab-content-wraper --}}
                                        </div>
                                    </div>
                                </div>
                            </div> {{-- /.main-body --}}
                        </div> {{-- /.down-body-wraper --}}
                    </div> {{-- /.profile-setting-wraper --}}
                </div>
            </div>
        </div>
    </div>
@endsection