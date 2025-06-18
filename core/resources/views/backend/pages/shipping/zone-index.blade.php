@extends('backend.admin-master')

@section('site-title', __('All Zone'))

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ __('All Shipping Zones') }}</h4>
        <a href="{{ route('admin.shipping.add') }}" class="btn btn-primary">{{ __('Add Zone') }}</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('Zone Name') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('State') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zones as $zone)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $zone->zone_name }}</td>
                        <td>{{ $zone->country->country ?? '-' }}</td>
                        <td>{{ $zone->state->state ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.shipping.edit', $zone->id) }}" class="btn btn-sm btn-info">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ route('admin.shipping.delete', $zone->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this zone?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

    </div>
</div>
@endsection