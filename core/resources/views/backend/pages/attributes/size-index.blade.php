@extends('backend.admin-master')

@section('site-title', __('All Sizes'))

@section('style')
<style>
    .icons { display: flex; align-items: center; gap: 10px; }
</style>
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6"><h5>Sizes</h5></div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.attributes.size.create') }}" class="btn btn-primary">
            Add Size
        </a>
    </div>

    @if(session('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered mt-25">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Size Code</th>
                <th>Slug</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sizes as $size)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $size->name }}</td>
                    <td>{{ $size->size_code }}</td>
                    <td>{{ $size->slug }}</td>
                    <td class="text-center icons">
                        <a href="{{ route('admin.attributes.size.edit', $size->id) }}"
                        class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.attributes.size.destroy', $size->id) }}"
                            method="POST"
                            style="display: inline-block;"
                            onsubmit="return confirm('Are you sure you want to delete this size?')">
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
                    <td colspan="5" class="text-center">No size given</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection