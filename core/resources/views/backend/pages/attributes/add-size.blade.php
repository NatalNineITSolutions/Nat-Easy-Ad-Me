@extends('backend.admin-master')

@section('site-title', __('Add Size'))

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <h5 class="mb-4">{{ __('Add Size') }}</h5>

        @php
            $isEdit = isset($size);
            $formRoute = $isEdit
                ? route('admin.attributes.size.update', $size->id)
                : route('admin.attributes.size.store');
        @endphp

        <form method="POST" action="{{ $formRoute }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">{{ __('Size Name') }}</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $size->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Size Code') }}</label>
                <input type="text" name="size_code" class="form-control"
                    value="{{ old('size_code', $size->size_code ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Slug') }}</label>
                <input type="text" name="slug" class="form-control"
                    value="{{ old('slug', $size->slug ?? '') }}">
                <small class="text-muted">{{ __('Optional. If left blank, it will be generated from name.') }}</small>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ $isEdit ? __('Update Size') : __('Save Size') }}
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