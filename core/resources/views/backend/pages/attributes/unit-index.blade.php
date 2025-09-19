@extends('backend.admin-master')

@section('site-title', __('All Items'))

@section('style')
<style>
    .icons { display: flex; align-items: center; gap: 10px; }
</style>
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6"><h5>Units</h5></div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.attributes.unit.create') }}" class="btn btn-primary">
            Add Unit
        </a>
    </div>

    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered mt-25">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($units as $unit)
                <tr>
                   <td>{{ $loop->iteration }}</td> 
                    <td>{{ $unit->name }}</td>
                    <td class="text-center icons">
                        <a href="{{ route('admin.attributes.unit.edit', $unit->id) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST"
                            action="{{ route('admin.attributes.unit.destroy', $unit->id) }}"
                            style="display: inline-block;"
                            onsubmit="return confirm('Are you sure you want to delete this unit?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No units found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection