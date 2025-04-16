@php
    use Illuminate\Support\Carbon;

    // Get today's date
    $today = now()->toDateString(); // e.g. "2025-04-16"

    // Filter the records for today's date using 'created_at'
    $todayIncome = collect($incomeData['days'] ?? [])->filter(function ($item) use ($today) {
    if (!is_array($item)) return false;
    
    // Try multiple possible date field names
    $dateField = $item['created_at'] ?? $item['date'] ?? $item['day'] ?? null;
    
    if (!$dateField) return false;
    
    try {
        return Carbon::parse($dateField)->toDateString() === $today;
    } catch (\Exception $e) {
        return false;
    }
});
@endphp

@extends('frontend.layout.master')

@section('site-title')
    {{ __('Income Statement') }}
@endsection

@section('content')
    <div class="profile-setting setting-page verify-identity section-padding2">
        <div class="container-1920 plr1">
            <div class="row">
                <div class="col-12">
                    <div class="profile-setting-wraper">
                        @include('frontend.user.layout.partials.user-profile-background-image')

                        <div class="down-body-wraper">
                            @include('frontend.user.layout.partials.sidebar')

                            <div class="main-body">
                                <x-frontend.user.responsive-icon />
                                <div class="setting-btn-part">
                                    <div class="setting-tab-content tab-content">
                                        <div class="tab-pane fade show active">
                                            <div class="tab-content-wraper box-shadow1">

                                                @if ($todayIncome->isNotEmpty())
                                                    <div class="card">
                                                        <div class="card-header text-white">
                                                            <h3 class="mb-0">INCOME STATEMENT</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <!-- Header Info -->
                                                            <div class="row mb-4">
                                                                <div class="col-md-6">
                                                                    <p><strong>GST NO:</strong> 33HHPT34(20B12S)</p>
                                                                    @php
                                                                        $kyc = $incomeData['kyc'] ?? null;
                                                                    @endphp

                                                                    @if ($kyc)
                                                                        <p><strong>Address:</strong> {{ $kyc->address ?? '-' }}, {{ $kyc->user_city->city ?? '-' }}, {{ $kyc->user_state->state ?? '-' }}, {{ $kyc->user_country->country ?? '-' }}</p>
                                                                        <p><strong>Pin Code:</strong> {{ $kyc->zip_code ?? '-' }}</p>
                                                                        <p><strong>Contact No:</strong> {{ $user->phone ?? '-' }}</p>
                                                                    @else
                                                                        <p><strong>Address:</strong> Not Available</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Sponsor Person Details -->
                                                            <div class="row mb-4">
                                                                <div class="col-md-12">
                                                                    <h5>SPONSOR PERSON DETAILS</h5>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <thead class="thead-light">
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
                                                                                        <p>Account Number : {{ $kyc->bank_account_no ?? '-' }}</p>
                                                                                        <p>IFSC Code : {{ $kyc->ifsc_code ?? '-' }}</p>
                                                                                        <p>Bank Name : {{ $kyc->bank_name ?? '-' }}</p>
                                                                                        <p>Branch : {{ $kyc->branch ?? '-' }}</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Income Details -->
                                                            <div class="row mb-4">
                                                                <div class="col-md-12">
                                                                    <h5>INCOME DETAILS ({{ $today }})</h5>
                                                                    <table class="table table-bordered">
                                                                        <thead class="thead-light">
                                                                            <tr>
                                                                                <th>Day</th>
                                                                                <th>Team CV</th>
                                                                                <th>Income</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($todayIncome as $day)
                                                                                <tr>
                                                                                    <td>{{ $day['day'] ?? $day['created_at'] }}</td>
                                                                                    <td>{{ $day['team_cv'] ?? 0 }}</td>
                                                                                    <td>{{ $day['income'] ?? 0 }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <!-- Summary Section -->
                                                            <div class="row">
                                                                <div class="col-md-6 offset-md-6">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Total Income</th>
                                                                            <td>{{ $incomeData['total_income'] ?? 0 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Product Coupon ({{ $incomeData['product_coupon'] ?? 0 }}%)</th>
                                                                            <td>{{ 0 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>TDS ({{ $incomeData['tds_percentage'] }}%)</th>
                                                                            <td>{{ $incomeData['total_income'] * $incomeData['tds'] / 100 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Service Charge ({{ $incomeData['service_charge_percentage'] }}%) </th>
                                                                            <td>{{ $incomeData['total_income'] * $incomeData['service_charge'] / 100 }}</td>
                                                                        </tr>
                                                                        <tr class="table-active">
                                                                            <th><strong>Net Amount</strong></th>
                                                                            <td><strong>{{ number_format($incomeData['net_amount'], 2) }}</strong></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <!-- Additional -->
                                                            <div class="row mt-3">
                                                                <div class="col-md-12">
                                                                    <p><strong>Direct Business BV:</strong> {{ $incomeData['direct_business_bv'] ?? 0 }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="alert alert-warning">
                                                        <strong>No Income Statement generated for {{ $today }}.</strong>
                                                    </div>
                                                @endif

                                            </div> <!-- tab-content-wraper -->
                                        </div> <!-- tab-pane -->
                                    </div> <!-- setting-tab-content -->
                                </div> <!-- setting-btn-part -->
                            </div> <!-- main-body -->
                        </div> <!-- down-body-wraper -->
                    </div> <!-- profile-setting-wraper -->
                </div>
            </div>
        </div>
    </div>

    <x-media.markup :type="'web'" />
@endsection
