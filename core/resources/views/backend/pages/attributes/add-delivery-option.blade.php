@extends('backend.admin-master')

@section('site-title', isset($deliveryOption) ? __('Edit Delivery Option') : __('Add Delivery Option'))

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
@php
    $isEdit = isset($deliveryOption);
    $formRoute = $isEdit
        ? route('admin.attributes.delivery.option.update', $deliveryOption->id)
        : route('admin.attributes.delivery.option.store');
@endphp

<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-4">{{ $isEdit ? __('Edit Delivery Option') : __('Add Delivery Option') }}</h5>

        <form method="POST" action="{{ $formRoute }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">{{ __('Title') }}</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $deliveryOption->title ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Subtitle') }}</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $deliveryOption->subtitle ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ $isEdit ? __('Update') : __('Save') }}
            </button>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
@endsection