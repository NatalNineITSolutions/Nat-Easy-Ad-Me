@extends('backend.admin-master')
@section('site-title')
    {{ __('Branch Payout History') }}
@endsection

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">{{ __('Branch Payout History') }}</h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Payout ID') }}</th>
                        <th>{{ __('Commission Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->id }}</td>
                            <td>{{ $history->branch->name ?? 'N/A' }}</td>
                            <td>{{ $history->payout->id ?? 'N/A' }}</td>
                            <td>{{ $history->total_commission }}</td>
                            <td>
                                @if($history->status == 1)
                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('Unpaid') }}</span>
                                @endif
                            </td>
                            <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $histories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection