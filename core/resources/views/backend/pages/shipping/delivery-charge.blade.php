@extends('backend.admin-master')

@section('site-title', __('Delivery Charges'))

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">{{ __('Delivery Charges by Zone') }}</h4>
        <a href="{{ route('admin.shipping.add.delivery.charge') }}" class="btn btn-primary">
            {{ __('Add Delivery Charges') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Zone') }}</th>
                    <th>{{ __('Weight (g)') }}</th>
                    <th>{{ __('Default Delivery Charge') }}</th>
                    <th>{{ __('Setting type') }}</th>
                    <th>{{ __('Minimum Order Amount') }}</th>
                    <th>{{ __('Delivery charge') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($charges as $charge)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $charge->zone->zone_name ?? '-' }}</td>
                        <td>{{ rtrim(rtrim(number_format($charge->weight, 2), '0'), '.') }} g</td>
                        <td>₹{{ number_format($charge->default_delivery_charge, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $charge->setting_type)) }}</td>
                        <td>{{ $charge->min_order ? number_format($charge->min_order, 2) : __('N/A') }}</td>
                        <td>₹{{ number_format($charge->delivery_charge, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.shipping.edit.delivery.charge', $charge->id) }}" class="btn btn-sm btn-info">
                                {{ __('Edit') }}
                            </a>
                            <form 
                                action="{{ route('admin.shipping.delete.delivery.charge', $charge->id) }}" 
                                method="POST" 
                                class="d-inline"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this delivery charge?') }}');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            {{ __('No delivery charges found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection