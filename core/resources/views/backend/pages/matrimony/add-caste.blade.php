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

        <form class="mt-25" method="POST" action="{{ isset($caste) ? route('admin.matrimony.update-caste', $caste->id) : route('admin.matrimony.store-caste') }}">
            @csrf
            @if(isset($caste))
                @method('PUT')
            @endif
        
            <div class="mb-3">
                <label for="caste" class="form-label">Caste</label>
                <input type="text" class="form-control" id="caste" name="caste" value="{{ $caste->caste ?? '' }}" required>
            </div>
        
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
    </div>

    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
    
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
    
            @if($errors->any())
                toastr.error("{{ $errors->first() }}");
            @endif
        });
    </script>
@endsection

<!-- jQuery (required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

