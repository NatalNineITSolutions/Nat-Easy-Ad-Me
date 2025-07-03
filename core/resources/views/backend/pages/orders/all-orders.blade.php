@extends('backend.admin-master')

@section('site-title', __('All Orders'))

@section('content')
<div class="col-lg-12">
    <div class="dashboard__card dashboard__card-two">
        <div class="card-header">
            <h4>{{ __('All Orders') }}</h4>
        </div>
        <div class="card-body">
            <div class="table-wrap table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Total Price') }}</th>
                            <th>{{ __('Delivery Charge') }}</th>
                            <th>{{ __('Grand Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Payment') }}</th>
                            <th>{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->name }}<br><small>{{ $order->email }}</small></td>
                            <td>
                                @php $productIds = explode('|', $order->product_id); @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach ($productIds as $pid)
                                        @php $product = \App\Models\Product::find($pid); @endphp
                                        <li>{{ $product->name ?? 'N/A' }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                @php $quantities = explode('|', $order->product_quantity); @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach ($quantities as $qty)
                                        <li>{{ $qty }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                @php $prices = explode('|', $order->product_total_price); @endphp
                                <ul class="list-unstyled mb-0">
                                    @foreach ($prices as $price)
                                        <li>₹{{ number_format((float)$price, 2) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>₹{{ number_format($order->total_delivery_charge, 2) }}</td>
                            <td>₹{{ number_format($order->grand_total, 2) }}</td>
                            
                            @php
                                $statuses = ['pending', 'packaging', 'shipped', 'delivered'];
                                $currentIndex = array_search($order->order_status, $statuses);
                                $availableStatuses = array_slice($statuses, $currentIndex); // show current and forward
                            @endphp

                            <td>
                                <form action="{{ route('admin.orders.update.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="order_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach($availableStatuses as $status)
                                            <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>

                            <td>
                                @if($order->is_paid)
                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('Unpaid') }}</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">{{ __('No orders found.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination-wrapper mt-4">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection