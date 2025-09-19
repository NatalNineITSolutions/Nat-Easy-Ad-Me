<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Order #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Invoice for Order #{{ $order->id }}</h2>
    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>
    <p><strong>Location:</strong> 
        {{ $order->city->city ?? '' }}, 
        {{ $order->state->state ?? '' }}, 
        {{ $order->country->country ?? '' }}
    </p>
    <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
    <p><strong>Paid:</strong> {{ $order->is_paid ? 'Yes' : 'No' }}</p>

    <h3>Order Items:</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product IDs</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Price (₹)</th>
                <th>Delivery (₹)</th>
                <th>Grand Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $order->product_id }}</td>
                <td>{{ $order->product_quantity }}</td>
                <td>{{ $order->size }}</td>
                <td>{{ $order->product_total_price }}</td>
                <td>{{ $order->total_delivery_charge }}</td>
                <td>{{ $order->grand_total }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Summary:</h3>
    <table>
        <tr>
            <th>Total Product Price</th>
            <td>{{ $order->product_total_price }}</td>
        </tr>
        <tr>
            <th>Delivery Charge</th>
            <td>{{ $order->total_delivery_charge }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td><strong>{{ $order->grand_total }}</strong></td>
        </tr>
    </table>
</body>
</html>