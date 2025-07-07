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
                                                            {{-- <tbody>
                                                                @foreach($orders as $order)
                                                                    @php
                                                                        $ids       = explode('|', $order->product_id);
                                                                        $qtys      = explode('|', $order->product_quantity);

                                                                        $partsPrice    = explode('|', $order->product_total_price);
                                                                        $productTotal  = (float) end($partsPrice);

                                                                        $partsDel      = explode('|', $order->total_delivery_charge);
                                                                        $deliveryTotal = (float) end($partsDel);

                                                                        $partsGrand    = explode('|', $order->grand_total);
                                                                        $grandTotal    = (float) end($partsGrand);
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>

                                                                        <td>
                                                                            <ul class="list-unstyled mb-0">
                                                                                @foreach($ids as $i => $pid)
                                                                                    @php
                                                                                        $prod = \App\Models\Product::find($pid);
                                                                                    @endphp
                                                                                    <li>{{ $prod->name ?? 'N/A' }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </td>

                                                                        <td>
                                                                            <ul class="list-unstyled mb-0">
                                                                                @foreach($qtys as $qty)
                                                                                    <li>{{ $qty }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </td>

                                                                        <td>₹{{ number_format($grandTotal, 2) }}</td>
                                                                        <td>
                                                                            <span class="badge bg-info text-dark text-capitalize">
                                                                                {{ $order->order_status }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            @if($order->is_paid)
                                                                                <span class="badge bg-success">Paid</span>
                                                                            @else
                                                                                <span class="badge bg-warning text-dark">Unpaid</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-nowrap">
                                                                            <a href="{{ route('user.order.view.details', $order->id) }}" class="btn btn-sm btn-outline-primary me-1" title="View Details">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{ route('user.order.invoice.download', $order->id) }}" class="btn btn-sm btn-outline-secondary" title="Download Invoice" target="_blank">
                                                                                <i class="fas fa-file-download me-1"></i> Invoice
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody> --}}
                                                            <tbody>
    @foreach($orders as $order)
        @php
            $productIds = explode('|', $order->product_id);
            $quantities = explode('|', $order->product_quantity);
            $prices     = explode('|', $order->product_total_price);
            $statuses   = explode('|', $order->order_status);
        @endphp

        @foreach($productIds as $index => $pid)
            @php
                $product = \App\Models\Product::find($pid);
                $qty     = $quantities[$index] ?? 0;
                $price   = $prices[$index] ?? 0;
                $status  = $statuses[$index] ?? 'pending';
                $grandTotal = $price + ($order->total_delivery_charge ?? 0);
            @endphp

            <tr>
                <td>{{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                <td>{{ $product->name ?? 'N/A' }}</td>
                <td>{{ $qty }}</td>
                <td>₹{{ number_format($grandTotal, 2) }}</td>
                <td>
                    <span class="badge bg-info text-dark text-capitalize">{{ $status }}</span>
                </td>
                <td>
                    @if($order->is_paid)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning text-dark">Unpaid</span>
                    @endif
                </td>
                <td class="text-nowrap">
                    <a href="{{ route('user.order.view.details.product', [$order->id, $index]) }}" class="btn btn-sm btn-outline-primary me-1" title="View Details">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('user.order.invoice.download.product', [$order->id, $index]) }}" class="btn btn-sm btn-outline-secondary" title="Download Invoice" target="_blank">
                        <i class="fas fa-file-download me-1"></i> Invoice
                    </a>
                </td>
            </tr>
        @endforeach
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