@extends('frontend.layout.master')

@section('site-title', 'Order Product Details')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="mb-4 text-primary">Order Summary</h2>

            <div class="row mb-2">
                <div class="col-md-6">
                    <p><strong>Distributor ID:</strong> {{ $partner_id ?? 'N/A' }}</p>
                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Address:</strong> {{ $order->address }}</p>
                    <p>
                        <strong>Payment:</strong>
                        <span class="badge bg-{{ $order->is_paid ? 'success' : 'danger' }}">
                            {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                        </span>
                    </p>
                    <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-3 text-primary">Product Details</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item['product']->name ?? 'N/A' }}</td>
                            <td>{{ $item['size'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₹{{ number_format($item['unitPrice'], 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $item['status'] === 'pending' ? 'warning text-dark' : 'success' }}">
                                    {{ ucfirst($item['status']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-4">
                <p><strong>Total BV:</strong> ₹{{ number_format($totalBV, 2) }}</p>
                <p><strong>Delivery Charge:</strong> ₹{{ number_format($deliveryCharge, 2) }}</p>
                <h5><strong>Grand Total:</strong> ₹{{ number_format($grandTotal, 2) }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection