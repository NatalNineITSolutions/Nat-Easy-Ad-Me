@extends('backend.admin-master')

@section('site-title')
    {{ __('Payout History for Branch: ') . $branch->name }}
@endsection

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">
        {{ __('Payout History for Branch: ') }} <span class="text-primary">{{ $branch->name }}</span>
    </h4>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('S.No.') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Commission Amount') }}</th>
                        <th>{{ __('Statement') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $key => $history)
                        <tr>
                            {{-- Calculate serial number based on pagination --}}
                            <td>{{ $histories->firstItem() + $key }}</td>
                            <td>{{ $history->created_at->format('d M Y') }}</td>
                            <td>Rs. {{ $history->total_commission }}</td>
                            <td>
                                <a href="{{ route('admin.branch.payout.history.download', $history->id) }}" 
                                class="btn btn-sm btn-primary">
                                    {{ __('Download') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('No payout history found for this branch') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $histories->links() }}
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.branch.payout.history') }}" class="btn btn-secondary">
                    {{ __('← Back to All Branches') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection