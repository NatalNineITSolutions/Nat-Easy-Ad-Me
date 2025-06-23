@extends('frontend.layout.master')

@section('site-title')
    {{ __('Order History') }}
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
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h3 class="mb-0">{{ __('Your Orders') }}</h3>
                                                </div>

                                                @if($orders->count())
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Total Price</th>
                                                                    <th>Delivery</th>
                                                                    <th>Grand Total</th>
                                                                    <th>Status</th>
                                                                    <th>Paid</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($orders as $order)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $order->product?->name ?? '-' }}</td>
                                                                        <td>{{ $order->product_quantity }}</td>
                                                                        <td>₹{{ number_format($order->product_total_price, 2) }}</td>
                                                                        <td>₹{{ number_format($order->total_delivery_charge, 2) }}</td>
                                                                        <td>₹{{ number_format($order->grand_total, 2) }}</td>
                                                                        <td>
                                                                            <span class="badge bg-info text-dark text-capitalize">{{ $order->order_status }}</span>
                                                                        </td>
                                                                        <td>
                                                                            @if($order->is_paid)
                                                                                <span class="badge bg-success">Paid</span>
                                                                            @else
                                                                                <span class="badge bg-warning text-dark">Unpaid</span>
                                                                            @endif
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

                                                {{-- Optional Pagination --}}
                                                {{-- <div class="pagination-wrapper mt-3 d-flex justify-content-center">
                                                    {{ $orders->links('pagination::bootstrap-4') }}
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /.main-body -->
                        </div> <!-- /.down-body-wraper -->
                    </div> <!-- /.profile-setting-wraper -->
                </div>
            </div>
        </div>
    </div>
@endsection