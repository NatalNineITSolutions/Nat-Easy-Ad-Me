@extends('frontend.layout.master')

@section('site-title')
    {{ __('Order History') }}
@endsection

@section('content')
    <div class="profile-setting setting-page section-padding2">
        <div class="container-1920 plr1">

            @if(session('success'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif

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
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h3 class="mb-0">{{ __('Your Orders') }}</h3>
                                                </div>

                                                @if($orders->count())
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SNo</th>
                                                                    <th>Product(s)</th>
                                                                    <th>Quantity</th>
                                                                    {{-- <th>Total Price</th>
                                                                    <th>Delivery</th> --}}
                                                                    <th>Grand Total</th>
                                                                    <th>Status</th>
                                                                    <th>Paid</th>
                                                                    <th>Action</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($orders as $order)
                                                                    @php
                                                                        $productIds = explode('|', $order->product_id ?? '');
                                                                        $quantities = explode('|', $order->product_quantity ?? '');
                                                                        $prices     = explode('|', $order->product_total_price ?? '');

                                                                        $productsDisplay = [];
                                                                        $quantitiesDisplay = [];
                                                                        $orderTotal = 0;

                                                                        foreach ($productIds as $index => $pid) {
                                                                            $product = \App\Models\Product::find($pid);
                                                                            $name = $product->name ?? 'N/A';

                                                                            $qty = isset($quantities[$index]) ? (int)$quantities[$index] : 0;
                                                                            $totalPriceForThatItem = isset($prices[$index]) && is_numeric($prices[$index]) ? (float)$prices[$index] : 0;

                                                                            $productsDisplay[] = $name;
                                                                            $quantitiesDisplay[] = $qty;

                                                                            $orderTotal += $totalPriceForThatItem; // ✅ no * qty
                                                                        }

                                                                        $deliveryCharge = is_numeric($order->total_delivery_charge) ? (float)$order->total_delivery_charge : 0;
                                                                        $grandTotal = $orderTotal + $deliveryCharge;
                                                                    @endphp

                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>

                                                                        {{-- Products --}}
                                                                        <td>
                                                                            @foreach($productsDisplay as $pIndex => $pName)
                                                                                <div>{{ $pIndex + 1 }}. {{ $pName }}</div>
                                                                            @endforeach
                                                                        </td>

                                                                        {{-- Quantities --}}
                                                                        <td>
                                                                            @foreach($quantitiesDisplay as $qty)
                                                                                <div>{{ $qty }}</div>
                                                                            @endforeach
                                                                        </td>

                                                                        {{-- Grand total (for whole order) --}}
                                                                        <td>₹{{ number_format((float) $order->grand_total, 2) }}</td>

                                                                        {{-- Status per product --}}
                                                                        <td>
                                                                            <span class="badge bg-info text-dark text-capitalize">
                                                                                {{ ucfirst($order->order_status) }}
                                                                            </span>
                                                                        </td>

                                                                        {{-- Payment status --}}
                                                                        <td>
                                                                            @if($order->is_paid)
                                                                                <span class="badge bg-success">Paid</span>
                                                                            @else
                                                                                <span class="badge bg-warning text-dark">Unpaid</span>
                                                                            @endif
                                                                        </td>

                                                                        {{-- Actions --}}
                                                                        <td class="text-nowrap">
                                                                            <a href="{{ route('user.order.view.details.product', [$order->id, 0]) }}" class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{ route('user.order.invoice.download.product', [$order->id, 0]) }}" class="btn btn-sm btn-outline-secondary" title="Download Invoice" target="_blank">
                                                                                <i class="fas fa-file-download me-1"></i> Invoice
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info text-center">
                                                        {{ __('You have not placed any orders yet.') }}
                                                    </div>
                                                @endif

                                                {{-- Optional pagination --}}
                                                {{-- 
                                                <div class="pagination-wrapper mt-3 d-flex justify-content-center">
                                                    {{ $orders->links('pagination::bootstrap-4') }}
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> {{-- /.down-body-wraper --}}
                    </div> {{-- /.profile-setting-wraper --}}
                </div>
            </div>
        </div>
    </div>
@endsection