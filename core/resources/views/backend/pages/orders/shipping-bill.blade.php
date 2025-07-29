<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipping Label - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        .label-container {
            width: 400px;
            border: 2px solid #000;
            padding: 10px 15px;
        }

        .section {
            border-bottom: 2px solid #000;
            padding: 10px 0;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .letter-box {
            font-size: 36px;
            font-weight: bold;
            border: 2px solid #000;
            padding: 10px;
            width: 50px;
            text-align: center;
        }

        .barcode {
            font-size: 18px;
            text-align: center;
            margin-top: 10px;
        }

        .tracking {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .address-block {
            font-size: 14px;
            line-height: 1.4;
        }

        .priority {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .weight {
            font-size: 14px;
        }

        .qr {
            width: 60px;
            height: 60px;
            border: 1px solid #000;
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div class="label-container">
        <!-- Header Row -->
        <div class="section top-row">
            <div class="letter-box">E</div>
        </div>

        <!-- Priority -->
        <div class="section priority">
            SHIPPING LABEL
        </div>

        <!-- From Address -->
        <div class="section">
            <div class="address-block">
                <strong>From:</strong><br>
                Easyadme<br>
                123 Admin Office Street<br>
                Hyderabad, India
            </div>
        </div>

        <!-- To Address -->
        <div class="section">
            <div class="address-block">
                <strong>Ship To:</strong><br>
                Name: {{ $userName }}<br>
                Phone: {{ $phone }}<br>
                {{ $order->address }}<br>
                @php
                    $location = [];
                    if (!empty($order->city?->city)) $location[] = $order->city->city;
                    if (!empty($order->state?->state)) $location[] = $order->state->state;
                    if (!empty($order->country?->country)) $location[] = $order->country->country;
                @endphp
                {{ implode(', ', $location) }}<br> 
                {{ $zipCode }}
            </div>
        </div>
    </div>
</body>
</html>