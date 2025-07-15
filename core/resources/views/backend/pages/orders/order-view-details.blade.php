@extends('backend.admin-master')

@section('site-title', 'Order Details')

@section('content')
<div class="col-lg-12">
    <div class="dashboard__card dashboard__card-two">
        <div class="card-header">
            <h4>Order Details (Order #{{ $order->id }})</h4>
        </div>
        <div class="card-body" style="font-size: 12px; margin: 10px 20px;">
            <div class="row mb-4">
                <div class="col-md-6 ps-3">
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                    @if($order->user?->sponsor)
                        <p><strong>Sponsor:</strong> {{ $order->user->sponsor->first_name }} {{ $order->user->sponsor->last_name }}</p>
                    @else
                        <p><strong>Sponsor:</strong> —</p>
                    @endif
                    <p><strong>Address:</strong><br>
                        {{ $order->address }}<br>
                        @php
                            $location = [];
                            if (!empty($order->city?->city)) $location[] = $order->city->city;
                            if (!empty($order->state?->state)) $location[] = $order->state->state;
                            if (!empty($order->country?->country)) $location[] = $order->country->country;
                        @endphp
                        {{ implode(', ', $location) }}
                    </p>
                </div>

                <div class="col-md-6 ps-3">
                    <p><strong>Order Status:</strong>
                        <span class="badge bg-{{ $order->order_status == 'pending' ? 'warning text-dark' : 'success' }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </p>
                    <p><strong>Payment:</strong>
                        <span class="badge bg-{{ $order->is_paid ? 'success' : 'danger' }}">
                            {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                        </span>
                    </p>
                    <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <h5 class="mb-3">Product Details</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" style="font-size: 14px;">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Price (₹)</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            @php
                                $statusList = explode('|', $order->order_status);
                                $currentStatus = $statusList[$index] ?? 'pending';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name ?? 'N/A' }}</td>
                                <td>{{ $sizes[$index] ?? '-' }}</td>
                                <td>{{ $quantities[$index] ?? '-' }}</td>
                                <td>₹{{ number_format($prices[$index] ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $currentStatus === 'pending' ? 'warning text-dark' : 'success' }}">
                                        {{ ucfirst($currentStatus) }}
                                    </span>
                                </td>
                                <td class="d-flex align-items-center gap-1">
                                    <form method="POST" action="{{ route('admin.orders.update.status.product', [$order->id, $index]) }}" class="d-flex align-items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <select name="order_status" class="form-select form-select-sm w-auto">
                                            @foreach(['pending', 'packaging', 'shipped', 'delivered'] as $status)
                                                <option value="{{ $status }}" {{ $currentStatus === $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary px-2 py-1">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.invoice.download.product', [$order->id, $index]) }}"
                                    class="btn btn-sm btn-outline-secondary px-2 py-1" target="_blank">
                                        <i class="fas fa-file-download me-1"></i>Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $productTotal = array_sum(array_map('floatval', explode('|', $order->product_total_price)));
                $deliveryCharge = floatval($order->total_delivery_charge);
                $grandTotal = floatval($order->grand_total);
            @endphp

            <div class="text-end mt-4 pe-2">
                <p><strong>Total Product Price:</strong> ₹{{ number_format($productTotal, 2) }}</p>
                <p><strong>Delivery Charge:</strong> ₹{{ number_format($deliveryCharge, 2) }}</p>
                <h5><strong>Grand Total:</strong> ₹{{ number_format($grandTotal, 2) }}</h5>
            </div>
        </div>

    </div>
</div>
@endsection