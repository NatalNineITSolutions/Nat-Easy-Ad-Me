@extends('backend.admin-master')

@section('site-title', __('Delivery Options'))

@section('style')
<style>
    .icons { display: flex; align-items: center; gap: 10px; }
</style>
@endsection

@section('content')
<div class="row align-items-center mt-20">
    <div class="col-md-6">
        <h5>{{ __('Delivery Options') }}</h5>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.attributes.delivery.option.create') }}" class="btn btn-primary">
            {{ __('Add Delivery Option') }}
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
                <th>Title</th>
                <th>Subtitle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deliveryOptions as $option)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $option->title }}</td>
                    <td>{{ $option->subtitle }}</td>
                    <td class="text-center icons">
                        <a href="{{ route('admin.attributes.delivery.option.edit', $option->id) }}"
                        class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.attributes.delivery.option.destroy', $option->id) }}"
                            method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Are you sure you want to delete this delivery option?');">
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
                    <td colspan="3" class="text-center">{{ __('No delivery options found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection