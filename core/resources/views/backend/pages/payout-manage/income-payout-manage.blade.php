@extends('backend.admin-master')
@section('site-title')
    {{__('Income Payout Manage')}}
@endsection

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Income Dividing System</h2>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Description</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Previous Case on Hand</td>
                    <td>{{ number_format($previousCaseOnHand) }}</td>
                </tr>
                <tr>
                    <td>Current Day Company BV</td>
                    <td>{{ number_format($currentDayBV) }}</td>
                </tr>
                <tr>
                    <td><strong>Total BV</strong></td>
                    <td><strong>{{ number_format($totalBV) }}</strong></td>
                </tr>
                <tr>
                    <td>Current Day Matching Pairs (One Distributor)</td>
                    <td>{{ $currentDayMatchingPairs }} (Paid: {{ $pairsToPay }})</td>
                </tr>
                <tr>
                    <td>One Day Maximum Ceiling</td>
                    <td>{{ $maximumDailyCeiling }}</td>
                </tr>
                <tr>
                    <td>Maximum One Pair Income</td>
                    <td>{{ number_format($pairIncome) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Output Amount</strong> ({{ $pairsToPay }} × {{ $pairIncome }})</td>
                    <td><strong>{{ number_format($totalOutPutAmount) }}</strong></td>
                </tr>
                <tr class="table-success">
                    <td><strong>Balance Case on Hand</strong></td>
                    <td><strong>{{ number_format($balanceCaseOnHand) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection