@extends('backend.admin-master')
@section('site-title')
    {{__('Add Castes')}}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>Add Mother Tongue</h5>
        </div>

        <form action="{{ isset($motherTongue) ? route('admin.matrimony.update-mother-tongue', $motherTongue->id) : route('admin.matrimony.store-mother-tongue') }}" method="POST" class="mt-4">
            @csrf
            @if(isset($motherTongue))
                @method('POST')
            @endif
            <div class="mb-3">
                <label for="mother_tongue" class="form-label">Mother Tongue</label>
                <input type="text" class="form-control" id="mother_tongue" name="mother_tongue" required value="{{ old('mother_tongue', $motherTongue->mother_tongue ?? '') }}">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
        
    </div>
@endsection

<!-- jQuery (required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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