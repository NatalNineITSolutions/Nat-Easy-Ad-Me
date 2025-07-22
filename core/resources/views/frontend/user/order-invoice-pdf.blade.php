<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Order #{{ $order->id }}</title>
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

    <p><strong>Distributor ID:</strong> {{ $partner_id ?? 'N/A' }}</p>
    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
    <p><strong>Address:</strong> {{ $order->address }}</p>
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
            @php $productTotal = 0; @endphp
            @foreach($products as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>₹{{ number_format($item['unit_price'], 2) }}</td>
                    <td>₹{{ number_format($item['price'], 2) }}</td>
                </tr>
                @php $productTotal += $item['price']; @endphp
            @endforeach
        </tbody>
    </table>

    <h4>Summary:</h4>
    <table>
        <tr>
            <th>Product Total</th>
            <td>₹{{ number_format($productTotal, 2) }}</td>
        </tr>
        <tr>
            <th>Delivery Charge</th>
            <td>₹{{ number_format($order->total_delivery_charge ?? 0, 2) }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <td><strong>₹{{ number_format($productTotal + ($order->total_delivery_charge ?? 0), 2) }}</strong></td>
        </tr>
    </table>

</body>
</html>