@extends('backend.admin-master')

@section('site-title')
    {{ isset($unit) ? __('Edit Unit') : __('Add Unit') }}
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-4">{{ isset($unit) ? __('Edit Unit') : __('Add Unit') }}</h5>

            @php
                $isEdit = isset($unit);
                $formRoute = $isEdit
                    ? route('admin.attributes.unit.update', $unit->id)
                    : route('admin.attributes.unit.store');
            @endphp

            <form method="POST" action="{{ $formRoute }}">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- Unit Name --}}
                <div class="mb-3">
                    <label class="form-label">{{ __('Unit Name') }}</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="{{ __('Enter unit name') }}"
                        value="{{ old('name', $unit->name ?? '') }}"
                        required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary mt-3">
                    {{ $isEdit ? __('Update Unit') : __('Save Unit') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Optional: show validation errors via toastr --}}
    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
@endsection