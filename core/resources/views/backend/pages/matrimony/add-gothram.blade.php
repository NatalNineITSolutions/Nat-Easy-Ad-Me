@extends('backend.admin-master')
@section('site-title')
    {{__('Add Gothram')}}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Add Gothram</h5>
        </div>
        
        <form action="{{ isset($gothram) ? route('admin.matrimony.update-gothram', $gothram->id) : route('admin.matrimony.store-gothram') }}" method="POST" class="mt-4">
            @csrf
            @if(isset($gothram))
                @method('PUT')
            @endif
        
            <div class="mb-3">
                <label for="gothram" class="form-label">Gothram</label>
                <input type="text" class="form-control" id="gothram" name="gothram" value="{{ $gothram->gothram ?? '' }}" required>
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

