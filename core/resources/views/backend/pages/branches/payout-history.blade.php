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
                        <th>{{ __('Branch') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branchHistory)
                        <tr>
                            <td>{{ $branchHistory->branch->name ?? 'N/A' }}</td>
                            <td>
                                @if($branchHistory->status == 1)
                                    <span class="badge bg-success">{{ __('Paid') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('Unpaid') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.branch.payout.history.view', $branchHistory->branch->id) }}" 
                                class="btn btn-info btn-sm">
                                    {{ __('View History') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $branches->links() }}
            </div>
        </div>
    </div>
</div>
@endsection