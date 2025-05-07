<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .user-header { background-color: #e9e9e9; font-weight: bold; padding: 8px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p>Generated on: {{ $date }}</p>
        @if($selectedDate)
        <p>For date: {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</p>
        @endif
    </div>

    <!-- Summary Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Partner ID</th>
                <th>Total Payout</th>
                <th>Total TDS</th>
                <th>Total Service</th>
                <th>Net Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                <td>{{ $user->partner_id }}</td>
                <td>{{ number_format($user->total_payout_amount, 2) }}</td>
                <td>{{ number_format($user->total_tds_deduction, 2) }}</td>
                <td>{{ number_format($user->total_service_charge, 2) }}</td>
                <td>{{ number_format($user->net_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4">Grand Total</td>
                <td>{{ number_format($total_payout, 2) }}</td>
                <td>{{ number_format($total_tds, 2) }}</td>
                <td>{{ number_format($total_service, 2) }}</td>
                <td>{{ number_format($total_net, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Detailed Transactions -->
    <h3>Transaction Details</h3>
    @foreach($users as $user)
    <div class="user-header">
        {{ $user->first_name }} {{ $user->last_name }} (ID: {{ $user->id }}, Partner ID: {{ $user->partner_id }})
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Payout Amount</th>
                <th>TDS Deduction</th>
                <th>Service Charge</th>
                <th>Net Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->transactions as $transaction)
            <tr>
                <td>{{ $transaction['date'] }}</td>
                <td>{{ number_format($transaction['payout_amount'], 2) }}</td>
                <td>{{ number_format($transaction['tds_deduction'], 2) }}</td>
                <td>{{ number_format($transaction['service_charge'], 2) }}</td>
                <td>{{ number_format($transaction['net_amount'], 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>Subtotal</td>
                <td>{{ number_format($user->total_payout_amount, 2) }}</td>
                <td>{{ number_format($user->total_tds_deduction, 2) }}</td>
                <td>{{ number_format($user->total_service_charge, 2) }}</td>
                <td>{{ number_format($user->net_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
</body>
</html>