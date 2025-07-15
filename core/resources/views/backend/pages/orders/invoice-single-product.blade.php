<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .invoice-box {
            border: 1px solid #ddd;
            padding: 25px;
            margin-top: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px 10px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .product-table th, .product-table td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Order Invoice</h2>
        <p><strong>Invoice #: </strong> {{ $order->id }} <br>
           <strong>Date: </strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
    </div>

    <div class="invoice-box">
        <div class="section-title">Customer Details</div>
        <table class="info-table">
            <tr>
                <td><strong>Name:</strong> {{ $order->name }}</td>
                <td><strong>Email:</strong> {{ $order->email }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong> {{ $order->phone_number }}</td>
                <td><strong>Address:</strong> {{ $order->address }}</td>
            </tr>
            @php
                $location = [];
                if (!empty($order->city?->city))   $location[] = $order->city->city;
                if (!empty($order->state?->state)) $location[] = $order->state->state;
                if (!empty($order->country?->country)) $location[] = $order->country->country;
            @endphp

            <tr>
                <td colspan="2">
                    <strong>Location:</strong> {{ implode(', ', $location) }}
                </td>
            </tr>
            @if($order->user?->sponsor)
                <tr>
                    <td colspan="2">
                        <strong>Sponsor:</strong>
                        {{ $order->user->sponsor->first_name ?? '' }}
                        {{ $order->user->sponsor->last_name ?? '' }}
                        ({{ $order->user->sponsor->username ?? '' }})
                    </td>
                </tr>
            @endif
        </table>

        <div class="section-title">Product Details</div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Unit Price (INR)</th>
                    <th>Total (INR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $product?->name ?? 'N/A' }}</td>
                    <td>{{ $size }}</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ ucfirst($status) }}</td>
                    <td class="text-right">
                        {{ number_format($quantity > 0 ? $price / $quantity : 0, 2) }}
                    </td>
                    <td class="text-right">{{ number_format($price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Summary</div>
        <table class="info-table">
            <tr>
                <td><strong>Delivery Charge:</strong></td>
                <td class="text-right">₹{{ number_format($order->total_delivery_charge ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Grand Total:</strong></td>
                <td class="text-right"><strong>₹{{ number_format($order->grand_total, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Transaction ID:</strong></td>
                <td class="text-right">{{ $order->transaction_id ?? 'Unpaid' }}</td>
            </tr>
            <tr>
                <td><strong>Payment Status:</strong></td>
                <td class="text-right">{{ $order->is_paid ? 'Paid' : 'Unpaid' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
