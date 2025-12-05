<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #eee; }
        .right { text-align: right; }
        .section-title { background:#f0f0f0; padding:6px; margin-top:10px; font-weight:bold; }
    </style>
</head>
<body>

    <h2 style="text-align:center;">{{ $title }}</h2>
    <p style="text-align:center;">Generated: {{ $date }}</p>

    {{-- SUMMARY TABLE --}}
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Partner ID</th>
            <th>Membership</th>
            <th class="right">BV Points</th>
            <th class="right">Order Total</th>
        </tr>
        </thead>

        <tbody>
        @foreach($users as $i => $user)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username ?? $user->first_name }}</td>
                <td>{{ $user->partner_id }}</td>
                <td>{{ optional(optional($user->membership)->membership)->title ?? 'Free' }}</td>
                <td class="right">{{ number_format($user->bv_total_points,2) }}</td>
                <td class="right">{{ number_format($user->orders_total_amount,2) }}</td>
            </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5">TOTAL</th>
                <th class="right">{{ number_format($total_bv_points,2) }}</th>
                <th class="right">{{ number_format($total_orders_amount,2) }}</th>
            </tr>
        </tfoot>
    </table>


    {{-- PER USER DETAILS --}}
    @foreach($users as $user)

        <div class="section-title">
            {{ $user->username ?? $user->first_name }} (ID: {{ $user->id }})
        </div>

        {{-- BV History --}}
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Points</th>
                    <th>Type</th>
                </tr>
            </thead>

            <tbody>
                @forelse($user->bv_transactions as $bv)
                    <tr>
                        <td>{{ $bv['date'] }}</td>
                        <td>{{ $bv['points'] }}</td>
                        <td>{{ ucfirst($bv['type']) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No BV history</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Orders --}}
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Products</th>
                    <th class="right">Total</th>
                </tr>
            </thead>

            <tbody>
                @forelse($user->order_transactions as $od)
                    <tr>
                        <td>{{ $od['date'] }}</td>
                        <td>{{ $od['products'] }}</td>
                        <td class="right">{{ number_format($od['total'],2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No Orders</td></tr>
                @endforelse
            </tbody>
        </table>

    @endforeach
</body>
</html>
