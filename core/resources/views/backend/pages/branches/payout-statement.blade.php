<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payout Statement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payout Statement</h2>
        <p><strong>Branch:</strong> {{ $branch }}</p>
        <p><strong>Period:</strong> {{ $fromDate }} to {{ $toDate }}</p>

        <table>
            <thead>
                <tr>
                    <th>Date Range</th>
                    <th>Commission Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $fromDate }} - {{ $toDate }}</td>
                    <td>Rs. {{ $amount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>