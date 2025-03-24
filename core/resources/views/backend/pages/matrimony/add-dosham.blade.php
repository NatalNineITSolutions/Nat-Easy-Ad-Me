@extends('backend.admin-master')
@section('site-title')
    {{__('Add Castes')}}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Add Caste</h5>
        </div>

        <form action="{{ isset($dosham) ? route('admin.matrimony.update-dosham', $dosham->id) : route('admin.matrimony.store-dosham') }}" method="POST" class="mt-4">
            @csrf
            @if(isset($dosham))
                @method('PUT')
            @endif
        
            <div class="mb-3">
                <label for="dosham" class="form-label">Dosham</label>
                <input type="text" class="form-control" id="dosham" name="dosham" required value="{{ $dosham->dosham ?? '' }}">
            </div>
        
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
    </div>

    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    
        @if($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif
    </script>
@endsection

<!-- jQuery (required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

