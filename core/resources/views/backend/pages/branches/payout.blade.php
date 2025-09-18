@extends('backend.admin-master')
@section('site-title')
    {{ __('Branches Payout Details') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ __('Branches Payout Details') }}</h4>

        {{-- Generate Payout Button --}}
        <form action="{{ route('admin.branch.payout.generate') }}" method="POST" onsubmit="return confirm('Are you sure you want to generate payout?')">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Generate Payout') }}
            </button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Commission %') }}</th>
                        <th>{{ __('Commission Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payouts as $payout)
                        <tr>
                            <td>{{ $payout->id }}</td>
                            <td>{{ $payout->branch->name ?? 'N/A' }}</td> 
                            <td>{{ $payout->commission_percent }}%</td>
                            <td>{{ $payout->commission_amount }}</td>
                           <td>
                                @if($payout->status == 1)
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $payouts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection