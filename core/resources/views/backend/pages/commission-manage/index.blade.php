@extends('backend.admin-master')
@section('site-title')
    {{ __('Level Commission History') }}
@endsection

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">{{ __('Level Commission History') }}</h4>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('S.No') }}</th>
                                <th>{{ __('Purchaser') }}</th>
                                <th>{{ __('Commission added to') }}</th>
                                <th>{{ __('Order ID') }}</th>
                                <th>{{ __('Level') }}</th>
                                <th>{{ __('Commission (%)') }}</th>
                                <th>{{ __('BV Added') }}</th>
                                <th>{{ __('Recorded At') }}</th>
                                <th>{{ __('Payout Status') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($histories as $history)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $history->purchaser->partner_name ?? 'N/A' }}</td>
                                    <td>{{ $history->upline->partner_name ?? 'N/A' }}</td>
                                    <td>{{ $history->order_id ?? '—' }}</td>
                                    <td>{{ $history->level ?? '—' }}</td>
                                    <td>{{ number_format($history->percentage ?? 0, 2) }}%</td>
                                    <td>{{ number_format($history->bv_added ?? 0, 2) }}</td>
                                    <td>{{ optional($history->created_at)->format('d M, Y h:i A') ?? '—' }}</td>
                                    <td>
                                        @if($history->is_paid)
                                            <span class="badge bg-success">{{ __('Completed') }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No commission history found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection