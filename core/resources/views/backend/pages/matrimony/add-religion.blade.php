@extends('backend.admin-master')
@section('site-title')
    {{ isset($religion) ? __('Edit Religion') : __('Add Religion') }}
@endsection

@section('content')
    <div class="row align-items-center mt-20">
        <div class="col-md-6">
            <h5>{{ isset($religion) ? 'Edit Religion' : 'Add Religion' }}</h5>
        </div>

        <form class="mt-25" method="POST" 
              action="{{ isset($religion) ? route('admin.matrimony.update-religion', $religion->id) : route('admin.matrimony.store-religion') }}">
            @csrf
            @if(isset($religion))
                @method('PUT')
            @endif
        
            <div class="mb-3">
                <label for="religion" class="form-label">Religion</label>
                <input type="text" class="form-control" id="religion" name="religion" 
                       value="{{ $religion->religion ?? old('religion') }}" required>
                @error('religion')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.matrimony.religion') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

@section('script')
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
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });
</script>
@endsection