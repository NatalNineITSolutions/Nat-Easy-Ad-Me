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
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $productIds = explode('|', $order->product_id);
                                $quantities = explode('|', $order->product_quantity);
                                $prices = explode('|', $order->product_total_price);
                                $statuses = explode('|', $order->order_status);
                                $totalProducts = count($productIds);
                            @endphp

                            @for ($i = 0; $i < $totalProducts; $i++)
                                @php
                                    $product = \App\Models\Product::find($productIds[$i] ?? null);
                                    $qty = $quantities[$i] ?? '-';
                                    $price = $prices[$i] ?? '0.00';
                                    $status = $statuses[$i] ?? 'pending';
                                @endphp
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $product->name ?? 'N/A' }}</td>
                                    <td>{{ $qty }}</td>
                                    <td>₹{{ number_format((float) $price, 2) }}</td>
                                    <td>₹{{ number_format($order->total_delivery_charge, 2) }}</td>
                                    <td>₹{{ number_format($order->grand_total, 2) }}</td>

                                    <td>
                                        <form action="{{ route('admin.orders.update.status.product', [$order->id, $i]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="order_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                @foreach(['pending', 'packaging', 'shipped', 'delivered'] as $option)
                                                    <option value="{{ $option }}" {{ $status === $option ? 'selected' : '' }}>
                                                        {{ ucfirst($option) }}
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

                                    <td class="d-flex gap-2">
                                        <a href="{{ route('admin.orders.view.details', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View Full Order">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.invoice.download.product', [$order->id, $i]) }}" class="btn btn-sm btn-outline-success" title="Invoice for Product" target="_blank">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endfor

                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">{{ __('No orders found.') }}</td>
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