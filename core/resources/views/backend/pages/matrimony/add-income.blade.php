@extends('backend.admin-master')
@section('site-title')
    {{ isset($income) ? __('Edit Income Range') : __('Add Income Range') }}
@endsection

@section('content')
<div class="row mt-20">
    <div class="col-md-6">
        <h5>{{ isset($income) ? 'Edit' : 'Add' }} Income Range</h5>
    </div>

    <form class="mt-25" method="POST" action="{{ isset($income) ? route('admin.matrimony.update-income', $income->id) : route('admin.matrimony.store-income') }}">
        @csrf
        @if(isset($income)) @method('PUT') @endif

        <div class="mb-3">
            <label for="from_income" class="form-label">From Income</label>
            <input type="number" class="form-control" id="from_income" name="from_income" value="{{ $income->from_income ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="to_income" class="form-label">To Income</label>
            <input type="number" class="form-control" id="to_income" name="to_income" value="{{ $income->to_income ?? '' }}" required>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
