<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Level Commission Payouts</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Level Based Commission Payouts</h2>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>User</th>
                <th>Payment Type</th>
                <th>Total BV</th>
                <th>TDS (%)</th>
                <th>Service Charge (%)</th>
                <th>Payout Amount</th>
                <th>Payout Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payouts as $index => $payout)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payout->user->first_name ?? $payout->user->name ?? 'N/A' }}
                    @if(isset($payout->user->last_name)) {{ ' ' . $payout->user->last_name }} @endif
                </td>
                <td>{{ ucfirst($payout->payment_type ?? 'manual') }}</td>
                <td>{{ number_format($payout->total_bv, 2) }}</td>
                <td>{{ number_format($payout->tds_percent ?? 0, 2) }}%</td>
                <td>{{ number_format($payout->service_charge_percent ?? 0, 2) }}%</td>
                <td>{{ number_format($payout->payout_amount ?? 0, 2) }}</td>
                <td>{{ optional($payout->payout_date)->format('d M, Y h:i A') ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
