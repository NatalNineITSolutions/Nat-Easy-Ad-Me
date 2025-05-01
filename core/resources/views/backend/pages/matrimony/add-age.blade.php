@extends('backend.admin-master')
@section('site-title')
    {{ isset($age) ? __('Edit Age Range') : __('Add Age Range') }}
@endsection

@section('content')
<div class="row mt-20">
    <div class="col-md-6">
        <h5>{{ isset($age) ? 'Edit' : 'Add' }} Age Range</h5>
    </div>

    <form class="mt-25" method="POST" action="{{ isset($age) ? route('admin.matrimony.update-age', $age->id) : route('admin.matrimony.store-age') }}">
        @csrf
        @if(isset($age)) @method('PUT') @endif

        <div class="mb-3">
            <label for="from_age" class="form-label">From Age</label>
            <input type="number" class="form-control" id="from_age" name="from_age" value="{{ $age->from_age ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="to_age" class="form-label">To Age</label>
            <input type="number" class="form-control" id="to_age" name="to_age" value="{{ $age->to_age ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        @if(session('success')) toastr.success("{{ session('success') }}"); @endif
        @if(session('error')) toastr.error("{{ session('error') }}"); @endif
        @if($errors->any()) toastr.error("{{ $errors->first() }}"); @endif
    });
</script>

<!-- Include Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
