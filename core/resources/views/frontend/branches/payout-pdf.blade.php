<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payout Statement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Payout Statement</h2>

    <p><strong>Branch:</strong> {{ $branch->name }}</p>
    <p><strong>Date:</strong> {{ $payout->created_at->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Commission Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <p><strong>Payout Period:</strong> {{ $fromDate }} to {{ $toDate }}</p>
                <td>₹ {{ number_format($payout->total_commission, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>