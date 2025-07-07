<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        h3, h4 { margin: 15px 0 5px; }
        p { margin: 5px 0; }
    </style>
</head>
<body>
    <h3>Invoice for Order #{{ $order->id }}</h3>

    @if($site_logo_url)
        <div style="margin-bottom: 20px;">
            <img src="{{ $site_logo_url }}" alt="Logo" style="height: 60px;">
        </div>
    @endif

    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
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

    <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <p><strong>Paid:</strong> {{ $order->is_paid ? 'Yes' : 'No' }}</p>

    <hr>

    <h4>Order Items:</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Price (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name ?? 'N/A' }}</td>
                    <td>{{ $sizes[$index] ?? '-' }}</td>
                    <td>{{ $quantities[$index] ?? '-' }}</td>
                    <td>₹{{ number_format($prices[$index] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Summary:</h4>
    <table>
        <tr>
            <th>Total Product Price</th>
            <td>₹{{ number_format($productTotal, 2) }}</td>
        </tr>
        <tr>
            <th>Delivery Charge</th>
            <td>₹{{ number_format($deliveryTotal, 2) }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td><strong>₹{{ number_format($grandTotal, 2) }}</strong></td>
        </tr>
    </table>
</body>
</html>