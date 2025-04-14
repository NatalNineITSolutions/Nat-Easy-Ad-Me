@extends('frontend.layout.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">INCOME STATEMENT</h3>
        </div>
        
        <div class="card-body">
            <!-- Header Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>GIST NG:</strong> 33HHPT34(20B12S)</p>
                    <p class="mb-1"><strong>No:</strong> 92 H. Manethotlothu vilei, Pithukadai Post,</p>
                    <p class="mb-1">Pin No: 629171, Kamyakumar District,</p>
                    <p class="mb-1">Tamil Nadu.</p>
                    <p class="mb-1"><strong>Contact No:</strong></p>
                </div>
            </div>

            <!-- Sports Person Details -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>SPORTS PERSON NAME</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Name</strong></p>
                            <p>{{ $incomeData['name'] ?? '' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Rank</strong></p>
                            <p>{{ $incomeData['rank'] ?? '' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Address & Bank Details</strong></p>
                            <p>{{ $incomeData['address'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Details -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>INCOME DETAILS</h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Duty</th>
                                <th>Team CV</th>
                                <th>INCOME</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeData['days'] ?? [] as $day)
                            <tr>
                                <td>{{ $day['name'] }}</td>
                                <td>{{ $day['team_cv'] ?? '' }}</td>
                                <td>{{ $day['income'] ?? '' }}</td>
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
                            <th>Total</th>
                            <td>{{ $incomeData['total'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>For product coupon 5%</th>
                            <td>{{ $incomeData['product_coupon'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Tabs 5%</th>
                            <td>{{ $incomeData['tabs'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Services change 5%</th>
                            <td>{{ $incomeData['service_charge'] ?? '' }}</td>
                        </tr>
                        <tr class="table-active">
                            <th><strong>Net Amount</strong></th>
                            <td><strong>{{ $incomeData['net_amount'] ?? '' }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- REPDirect Business Bus (if needed) -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <p>REPDirect Business Bus</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection