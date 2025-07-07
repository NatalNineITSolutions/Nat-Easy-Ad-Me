<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Order #{{ $order->id }} - {{ $product->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        h3, h4 {
            margin-bottom: 10px;
        }
        .logo {
            height: 60px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h3>Invoice for Order #{{ $order->id }}</h3>
    <img src="{{ public_path('assets/uploads/media-uploader/logo.jpg') }}" alt="Easyadme Logo" class="logo">

    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>
    <p><strong>Status:</strong> {{ ucfirst($status) }}</p>
    <p><strong>Paid:</strong> {{ $order->is_paid ? 'Yes' : 'No' }}</p>
    <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? '—' }}</p>
    <hr>

    <h4>Product Details:</h4>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Unit Price (₹)</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->name ?? 'N/A' }}</td>
                <td>{{ $size }}</td>
                <td>{{ $quantity }}</td>
                <td>₹{{ number_format($product->distributor_price, 2) }}</td>
                <td>₹{{ number_format($price, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Summary:</h4>
    <table>
        <tr>
            <th>Product Total</th>
            <td>₹{{ number_format($price, 2) }}</td>
        </tr>
        <tr>
            <th>Delivery Charge</th>
            <td>₹{{ number_format($order->total_delivery_charge ?? 0, 2) }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td><strong>₹{{ number_format($price + ($order->total_delivery_charge ?? 0), 2) }}</strong></td>
        </tr>
    </table>

</body>
</html>