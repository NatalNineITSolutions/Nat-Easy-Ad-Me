<!DOCTYPE html>
<html>
<head>
    <title>Income Statement - {{ $incomeData['today'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }
        .mt-3 {
            margin-top: 1rem;
        }
        .table-active {
            background-color: #f8f9fa;
        }
        h3, h5 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h3>INCOME STATEMENT</h3>
            <div>Date: {{ $incomeData['today'] }}</div>
        </div>

        <!-- Header Info -->
        <div class="mb-3">
            <p><strong>GST NO:</strong> 33HHPT34(20B12S)</p>
            @php
                $kyc = $incomeData['kyc'] ?? null;
            @endphp

            @if ($kyc)
                <p><strong>Address:</strong> {{ $kyc->address ?? '-' }}, {{ $kyc->user_city->city ?? '-' }}, {{ $kyc->user_state->state ?? '-' }}, {{ $kyc->user_country->country ?? '-' }}</p>
                <p><strong>Pin Code:</strong> {{ $kyc->zip_code ?? '-' }}</p>
                <p><strong>Contact No:</strong> {{ auth()->user()->phone ?? '-' }}</p>
            @else
                <p><strong>Address:</strong> Not Available</p>
            @endif
        </div>

        <!-- Sponsor Person Details -->
        <div class="mb-3">
            <h5>SPONSOR PERSON DETAILS</h5>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Bank Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $incomeData['name'] ?? '-' }}</td>
                        <td>{{ $kyc->address ?? '-' }}</td>
                        <td>
                            <p>Account Number: {{ $kyc->bank_account_no ?? '-' }}</p>
                            <p>IFSC Code: {{ $kyc->ifsc_code ?? '-' }}</p>
                            <p>Bank Name: {{ $kyc->bank_name ?? '-' }}</p>
                            <p>Branch: {{ $kyc->branch ?? '-' }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Income Details -->
        <div class="mb-3">
            <h5>INCOME DETAILS ({{ $incomeData['today'] }})</h5>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Team CV</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomeData['today_income'] as $day)
                        <tr>
                            <td>{{ $day['day'] ?? $day['created_at'] }}</td>
                            <td>{{ $day['team_cv'] ?? 0 }}</td>
                            <td>{{ $day['income'] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div>
            <table style="width: 50%; margin-left: auto;">
                <tr>
                    <th>Total Income</th>
                    <td>{{ $incomeData['total_income'] ?? 0 }}</td>
                </tr>
                <tr>
                    <th>Product Coupon ({{ $incomeData['product_coupon'] ?? 0 }}%)</th>
                    <td>0</td>
                </tr>
                <tr>
                    <th>TDS ({{ $incomeData['tds_percentage'] }}%)</th>
                    <td>{{ $incomeData['tds'] }}</td>
                </tr>
                <tr>
                    <th>Service Charge ({{ $incomeData['service_charge_percentage'] }}%)</th>
                    <td>{{ $incomeData['service_charge'] }}</td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <th><strong>Net Amount</strong></th>
                    <td><strong>{{ number_format($incomeData['net_amount'], 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Additional -->
        <div class="mt-3">
            <p><strong>Direct Business BV:</strong> {{ $incomeData['direct_business'] }}</p>
        </div>
    </div>
</body>
</html>